<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Enquiry;
use DB;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\Visit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function adminHome(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $query = Enquiry::query();
    
           
    //         if ($request->has('search') && $request->search['value'] != '') {
    //             $search = $request->search['value'];
    
    //             $query->where(function ($query) use ($search) {
    //                 $query->whereRaw('LOWER(enquiries.school_name) LIKE ?', ['%' . strtolower($search) . '%'])
    //                       ->orWhereRaw('LOWER(enquiries.city) LIKE ?', ['%' . strtolower($search) . '%']);
                         
    //             });
                
    //         }
            
    
    //         return Datatables::of($query)
    //                 ->addIndexColumn()
    //                 ->addColumn('action', function($row){
    //                     $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    //                     return $btn;
    //                 })
    //                 ->rawColumns(['action'])
    //                 ->make(true);
    //     }
    
    //     return view('admin.adminindex');
    // }
    public function adminHome(Request $request)
{
    if ($request->ajax()) {
        $data = Enquiry::query();



        if ($request->has('city') && $request->city != '') {
            $data->where('enquiries.city', $request->city);
        }

        if ($request->has('crm') && $request->crm != '') {
            $data->where('enquiries.user_id', $request->crm);
        }
        

        // if ($request->has('status') && $request->status != '') {
        //     $data->where('enquiries.status', $request->status); 
        // }

        if ($request->has('status') && $request->status != '') {
            $data->whereIn('enquiries.id', function ($query) use ($request) {
                $query->select('enquiry_id')
                      ->from('visits as v1')
                      ->where('update_status', $request->status)
                      ->whereRaw('v1.id = (
                            SELECT v2.id FROM visits v2
                            WHERE v2.enquiry_id = v1.enquiry_id
                            ORDER BY v2.created_at DESC
                            LIMIT 1
                        )');
            });
        }
        $data->with(['visits' => function($query) {
            $query->latest()->take(1); 
        }]);

        $data->leftJoin('users', 'enquiries.user_id', '=', 'users.id')
            ->select('enquiries.*', 'users.name as crm_name');

        $data->orderByDesc('enquiries.created_at'); // Ensure that the most recent enquiries come first

       
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('last_visit', function ($row) {
                    $lastVisit = $row->visits->first();
                    if ($lastVisit) {
                        return \Carbon\Carbon::parse($lastVisit->date_of_visit)->format('d-m-Y');
                    }
                    return 'N/A';
                })
            ->addColumn('visit_remarks', function($row) {
                $lastVisit = $row->visits->first(); // Fetch the latest visit
                return $lastVisit ? $lastVisit->visit_remarks : 'No Remarks';
            })
            ->addColumn('follow_up_date', function($row) {
                // Fetch the latest visit
                $lastVisit = $row->visits->first(); 

                // Check if follow_up_date is null and show follow_na instead
                if ($lastVisit && $lastVisit->follow_up_date) {
                   return \Carbon\Carbon::parse($lastVisit->follow_up_date)->format('d-m-Y');
                }

                // If follow_up_date is null, show follow_na details
                return $lastVisit ? $lastVisit->follow_na : 'N/A';
            })
            ->addColumn('update_status', function ($row) {
                $lastVisit = $row->visits->first();

                // \Log::info('Visit status check', [
                //     'Enquiry ID' => $row->id,
                //     'Visit Status' => optional($lastVisit)->update_status,
                // ]);

                if (!$lastVisit) {
                    return '<span class="badge bg-secondary">No Visit</span>';
                }
                if ($lastVisit->update_status == 0) {
                    return '<span class="badge bg-warning">Running</span>';
                } else if ($lastVisit->update_status == 1) {
                    return '<span class="badge bg-success">Converted</span>';
                } else if ($lastVisit->update_status == 2) {
                    return '<span class="badge bg-danger">Rejected</span>';
                } else if ($lastVisit->update_status == 3) {
                    return '<span class="badge bg-info text-dark">R-Converted</span>';
                } else if ($lastVisit->update_status == 4) {
                    return '<span class="badge bg-dark">R-Rejected</span>';
                } else {
                    return '<span class="badge bg-secondary">Unknown</span>';
                }
            })
            ->addColumn('crm_name', function($row) {
                return $row->crm_name;  
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                return $btn;
            })
            ->rawColumns(['action', 'update_status'])
            ->make(true);
    }

    // Get distinct values for filters (you can remove or adjust this logic)
    $enquiries = Enquiry::all();
    $cities = Enquiry::distinct()->pluck('city');
    $statuses = ['0' => 'Running', '1' => 'Converted', '2' => 'Rejected', '3' => 'R-Converted', '4' => 'R-Rejected'];

    // Fetch CRM details where type is 0
    $crms = User::where('type', 0)->pluck('name', 'id')->toArray(); 
   

   
    $enquiries = Enquiry::whereHas('visits', function ($query) {
        $query->whereIn('update_status', [3, 4]);
    })
    ->with([
        'user',
        'visits' => function ($query) {
            $query->orderByDesc('created_at')->limit(1);
        },
    ])
    ->get();

    $enquiries = $enquiries->filter(function ($enquiry) {
        $latestVisit = $enquiry->visits->first();
        return $latestVisit && in_array($latestVisit->update_status, [3, 4]);
    });

    foreach ($enquiries as $enquiry) {
        $enquiry->crm_user_name = optional($enquiry->user)->name;

        if ($enquiry->visits->isNotEmpty()) {
            $visit = $enquiry->visits->first();
            $visit->crm_user_name = optional($visit->user)->name;
        }
    }
    $totalPending = $enquiries->count();
     

    return view('admin.adminindex', compact('cities', 'statuses', 'crms', 'enquiries','totalPending'));
}

    

public function admin_expired_follow_up(Request $request)
{
    $query = Enquiry::query()->with(['visits' => function ($visitQuery) use ($request) {
        $visitQuery->where('follow_up_date', '<>', 'n/a');

        $now = Carbon::now('Asia/Kolkata');

        if ($now->hour >= 12) {
            $visitQuery->where('follow_up_date', '<=', $now->toDateString());
        } else {
            $visitQuery->where('follow_up_date', '<', $now->toDateString());
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            try {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('Y-m-d');
                $toDate   = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('Y-m-d');
                
                $visitQuery->whereBetween('follow_up_date', [$fromDate, $toDate]);
            } catch (\Exception $e) {
                return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
            }
        }
    }]);

    $enquiries = $query->get();

    $noDataFound = $enquiries->isEmpty() || $enquiries->every(fn($enquiry) => $enquiry->visits->isEmpty());

    foreach ($enquiries as $enquiry) {
        foreach ($enquiry->visits as $visit) {
            $visit->follow_up_date = Carbon::parse($visit->follow_up_date)->format('d-m-Y');
        }
    }

    return view('admin.enquiry.admin_expired_follow', compact('enquiries', 'noDataFound'));
}


public function admin_visit_record(Request $request)
{
    $query = Enquiry::query()->with(['visits' => function ($visitQuery) use ($request) {
        if ($request->filled('from_date') && $request->filled('to_date')) {
            try {
                $fromDate = $request->from_date;
                $toDate = $request->to_date;

                $visitQuery->whereBetween('date_of_visit', [$fromDate, $toDate]);
            } catch (\Exception $e) {
                return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
            }
        }

        if ($request->filled('visit_type')) {
            $visitType = $request->visit_type;
            if ($visitType === 'New Meeting') {
                $visitQuery->where('visit_type', 1); 
            } elseif ($visitType === 'Follow-up') {
                $visitQuery->where('visit_type', 0); 
            }
        }
    }]);

    if ($request->has('today_visit') && $request->today_visit == 'today') {
        $query->whereDate('created_at', '=', Carbon::today());
    }

    $enquiries = $query->get();
    $enquiryCount = $query->withCount('visits')->count();
    $users = User::select('id', 'name', 'created_at')
    ->where('type',0)
    ->orderBy('id', 'asc')
    ->get();
    return view('admin.enquiry.admin_visit_record', compact('enquiries', 'enquiryCount','users'));
}

public function assing_crm(Request $request){
    $users = User::select('id', 'name', 'created_at')
            ->where('type', 0)
            ->orderBy('id', 'asc')
            ->get();

    $enquiries = Enquiry::with('user') 
                ->get();


    $noDataFound = $users->isEmpty();
    $totalCount = $enquiries->count();

    return view('admin.follow_up.assin_crm_admin', compact('users', 'enquiries', 'noDataFound', 'totalCount'));
}


public function view_details(Request $request,$id){
    $id = intval($id);
    $enquiries = Enquiry::where('id', $id)->get();

    return view('admin.enquiry.details',compact('enquiries'));
}

public function crm(Request $request)
{
    $users = User::select('*') 
                 ->orderBy('id', 'asc')
                 ->where('type',0)
                 ->get();

                 

    $noDataFound = $users->isEmpty();
    $totalCount = $users->count();

   
    return view( 'admin.follow_up.crm_admin', compact('users', 'noDataFound','totalCount'));

}
    public function follow_up(Request $request)
    {
        $query = Enquiry::query()->with([
            'visits' => function ($visitQuery) use ($request) {
                $visitQuery->where('follow_up_date', '<>', 'n/a');
    
                $today = Carbon::now('Asia/Kolkata')->toDateString();
    
                $visitQuery->where('follow_up_date', '>=', $today);
    
                if ($request->filled('from_date') && $request->filled('to_date')) {
                    try {
                        $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->toDateString();
                        $toDate   = Carbon::createFromFormat('Y-m-d', $request->to_date)->toDateString();
    
                        $visitQuery->whereBetween('follow_up_date', [$fromDate, $toDate]);
                    } catch (\Exception $e) {
                        return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
                    }
                }
            },
            'user',  
        ]);
    
        $enquiries = $query->get();
    
        $noDataFound = $enquiries->isEmpty() || $enquiries->every(fn($enquiry) => $enquiry->visits->isEmpty());
    
        foreach ($enquiries as $enquiry) {
            $enquiry->crm_user_name = $enquiry->user ? $enquiry->user->name : null;
    
            foreach ($enquiry->visits as $visit) {
                $visit->crm_user_name = $visit->user ? $visit->user->name : null;
            }
        }
    
        return view('admin.follow_up.admin_follow_up', compact('enquiries', 'noDataFound'));
    }
    
    // public function pending_request(Request $request)
    // {
    //     $query = Enquiry::query()->with([
    //         'visits' => function ($visitQuery) use ($request) {
    //             $visitQuery->where(function ($query) {
    //                 $query->whereNotNull('follow_up_date')
    //                       ->orWhereNotNull('follow_na');
    //             });
    
    //             $today = Carbon::now('Asia/Kolkata')->toDateString();
    
    //             $visitQuery->where(function ($query) use ($today) {
    //                 $query->where('follow_up_date', '>=', $today)
    //                       ->orWhere('follow_na', '>=', $today);
    //             });
    
    //             if ($request->filled('from_date') && $request->filled('to_date')) {
    //                 try {
    //                     $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->toDateString();
    //                     $toDate   = Carbon::createFromFormat('Y-m-d', $request->to_date)->toDateString();
    
    //                     $visitQuery->where(function ($query) use ($fromDate, $toDate) {
    //                         $query->whereBetween('follow_up_date', [$fromDate, $toDate])
    //                               ->orWhereBetween('follow_na', [$fromDate, $toDate]);
    //                     });
    //                 } catch (\Exception $e) {
    //                     return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
    //                 }
    //             }
    
    //             $visitQuery->orderByDesc('date_of_visit')->take(1);     },
    //         'user',  
    //     ]);
    
    //     $enquiries = $query->get();
    
    //     $noDataFound = $enquiries->isEmpty() || $enquiries->every(fn($enquiry) => $enquiry->visits->isEmpty());
    
    //     foreach ($enquiries as $enquiry) {
    //         $enquiry->crm_user_name = $enquiry->user ? $enquiry->user->name : null;
    
    //         if ($enquiry->visits->isNotEmpty()) {
    //             $latestVisit = $enquiry->visits->first();  
    //             $latestVisit->crm_user_name = $latestVisit->user ? $latestVisit->user->name : null;
    //         }
    //     }

    //     $totalCount = $enquiries->filter(fn($enquiry) => $enquiry->visits->isNotEmpty())->count();

    
    //     return view('admin.follow_up.pending_request', compact('enquiries', 'totalCount', 'noDataFound'));
    // }
    
    public function pending_request(Request $request)
{
    $enquiries = Enquiry::whereHas('visits', function ($query) {
        $query->whereIn('update_status', [3, 4]);
    })
    ->with([
        'user',
        'visits' => function ($query) {
            $query->orderByDesc('created_at')->limit(1);
        },
    ])
    ->get();

    $enquiries = $enquiries->filter(function ($enquiry) {
        $latestVisit = $enquiry->visits->first();
        return $latestVisit && in_array($latestVisit->update_status, [3, 4]);
    });

    // Add CRM user names to each enquiry and visit
    foreach ($enquiries as $enquiry) {
        $enquiry->crm_user_name = optional($enquiry->user)->name;

        // Attach CRM name to the latest visit as well
        if ($enquiry->visits->isNotEmpty()) {
            $visit = $enquiry->visits->first();
            $visit->crm_user_name = optional($visit->user)->name;
        }
    }

    return view('admin.follow_up.pending_request', [
        'enquiries' => $enquiries,
        'totalCount' => $enquiries->count(),
        'noDataFound' => $enquiries->isEmpty(),
    ]);
}


    public function updateVisitSastatus(Request $request)
    {
        $validated = $request->validate([
            'visit_status' => 'required|integer',  
            'visit_id' => 'integer',  
            'enquiry_id' => 'required|exists:enquiries,id',  
        ]);

        $statusCode = $request->input('status_code');
        $visitStatus = $validated['visit_status'];
        $enquiryId = $validated['enquiry_id'];
        $visit_id = $validated['visit_id'];
        
        $enquiry = Enquiry::findOrFail($enquiryId);
        $visit = $visit_id; 
    
        if ($visit) {
            if ($visitStatus == 3 && $statusCode == 1) {  
                $visit_status = 1;
            } elseif ($visitStatus == 4 && $statusCode == 1) {  
                $visit_status = 2;
            } elseif ($statusCode == 0) {  
                $visit_status = 0;  
            }

            $visit->save();
            
            $enquiry->status = $visit_status;  
            $enquiry->save();  
        }
    
        return redirect()->back()->with('success', 'Request status updated successfully.');
    }
    
    public function updateVisitStatus(Request $request)
{
    $validated = $request->validate([
        'visit_status' => 'required|integer',
        'visit_id' => 'integer',
        'enquiry_id' => 'required|exists:enquiries,id',
    ]);

    $statusCode = $request->input('status_code');
    $visitStatus = $validated['visit_status'];
    $enquiryId = $validated['enquiry_id'];
    $visit_id = $validated['visit_id'];
    
    $enquiry = Enquiry::findOrFail($enquiryId);
    
    $visit = Visit::find($visit_id); 

    if ($visit) {
        if ($visitStatus == 3 && $statusCode == 1) {
            $visit_status = 1;
        } elseif ($visitStatus == 4 && $statusCode == 1) {
            $visit_status = 2;
        } elseif ($statusCode == 0) {
            $visit_status = 0;
        }

        $visit->update(['update_status' => $visit_status]);

        $enquiry->status = $visit_status;
        $enquiry->save();
        

        Visit::where('id', $visit_id)->update(['update_status' => $visit_status]);

        return redirect()->back()->with('success', 'Request status updated successfully.');
    }

    // If the visit wasn't found, return an error
    return redirect()->back()->with('error', 'Visit not found.');
}


public function updateCrm(Request $request, $id)
{
    
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $enquiry = Enquiry::findOrFail($id);
    $enquiry->user_id = $request->user_id;
    $enquiry->save();

    return redirect()->back()->with('success', 'CRM updated successfully!');
}



    
}
