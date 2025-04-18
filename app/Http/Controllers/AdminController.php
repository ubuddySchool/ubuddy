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

        if ($request->has('status') && $request->status != '') {
            $data->where('enquiries.status', $request->status); 
        }

        if ($request->has('flow') && $request->flow != '') {
            $data->whereHas('visits', function($query) use ($request) {
                $query->latest()->take(1);  
                if ($request->flow == 0) {
                    $query->where('update_flow', 0); // Visited
                } elseif ($request->flow == 1) {
                    $query->where('update_flow', 1); // Meeting Done
                } elseif ($request->flow == 2) {
                    $query->where('update_flow', 2); // Demo Given
                }
            });
        }

        // Eager load the latest visit (only the most recent visit per enquiry)
        $data->with(['visits' => function($query) {
            $query->latest()->take(1); // Take only the most recent visit
        }]);

        // Left Join with 'users' table
        $data->leftJoin('users', 'enquiries.user_id', '=', 'users.id')
            ->select('enquiries.*', 'users.name as crm_name');

        $data->orderByDesc('enquiries.created_at'); // Ensure that the most recent enquiries come first

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('last_visit', function($row) {
                $lastVisit = $row->visits->first(); // Fetch the latest visit
                if ($lastVisit) {
                    // return $lastVisit->date_of_visit . ' ' . $lastVisit->time_of_visit;
                    return \Carbon\Carbon::parse($lastVisit->date_of_visit)->format('d-m-Y').' ' . $lastVisit->time_of_visit;
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
            ->addColumn('update_status', function($row) {
                if ($row->status == 0) return '<span class="badge bg-warning">Running</span>';
                if ($row->status == 1) return '<span class="badge bg-success">Converted</span>';
                if ($row->status == 2) return '<span class="badge bg-danger">Rejected</span>';
                return '<span class="badge bg-secondary">Unknown</span>';
            })
            ->addColumn('crm_name', function($row) {
                return $row->crm_name;  
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                return $btn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    // Get distinct values for filters (you can remove or adjust this logic)
    $enquiries = Enquiry::all();
    $cities = Enquiry::distinct()->pluck('city');
    $flows = ['0' => 'Visited', '1' => 'Meeting Done', '2' => 'Demo Given']; // Static flow options
    $statuses = ['0' => 'Running', '1' => 'Converted', '2' => 'Rejected']; // Static status options
    
    // Fetch CRM details where type is 0
    $crms = User::where('type', 0)->pluck('name', 'id')->toArray(); 
   

   

    $totalPending = DB::table('visits')
    ->whereIn('update_status', [1, 2])  
    ->select('user_id') 
    ->groupBy('user_id') 
    ->orderByDesc('created_at')  
    ->distinct()  
    ->count();
     

    return view('admin.adminindex', compact('cities', 'statuses', 'flows', 'crms', 'enquiries','totalPending'));
}

    

public function admin_expired_follow_up(Request $request)
{
    // Query for Enquiries
    $query = Enquiry::query()->with(['visits' => function ($visitQuery) use ($request) {
        // Filter out visits where follow-up date is 'n/a'
        $visitQuery->where('follow_up_date', '<>', 'n/a');

        // Get current date & time in 'Asia/Kolkata' timezone
        $now = Carbon::now('Asia/Kolkata');

        // Show only past follow-up dates OR today's if time is past 12:00 PM
        if ($now->hour >= 12) {
            $visitQuery->where('follow_up_date', '<=', $now->toDateString());
        } else {
            $visitQuery->where('follow_up_date', '<', $now->toDateString());
        }

        // Apply Date Range Filter
        if ($request->filled('from_date') && $request->filled('to_date')) {
            try {
                // Convert date from YYYY-MM-DD to dd-mm-yyyy format for comparison
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('Y-m-d');
                $toDate   = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('Y-m-d');
                
                // Add the date range condition
                $visitQuery->whereBetween('follow_up_date', [$fromDate, $toDate]);
            } catch (\Exception $e) {
                return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
            }
        }
    }]);

    // Get all enquiries and their visits
    $enquiries = $query->get();

    // Check if there is no data found
    $noDataFound = $enquiries->isEmpty() || $enquiries->every(fn($enquiry) => $enquiry->visits->isEmpty());

    // Format the 'follow_up_date' for display as dd-mm-yyyy
    foreach ($enquiries as $enquiry) {
        foreach ($enquiry->visits as $visit) {
            // Convert to dd-mm-yyyy format
            $visit->follow_up_date = Carbon::parse($visit->follow_up_date)->format('d-m-Y');
        }
    }

    // Return the view with enquiries data
    return view('admin.enquiry.admin_expired_follow', compact('enquiries', 'noDataFound'));
}


public function admin_visit_record(Request $request)
{
    $query = Enquiry::query()->with(['visits' => function ($visitQuery) use ($request) {
        // Handle date range filtering
        if ($request->filled('from_date') && $request->filled('to_date')) {
            try {
                // Directly use 'from_date' and 'to_date' as they are in 'YYYY-MM-DD' format
                $fromDate = $request->from_date; // No need to convert since it's already in the correct format
                $toDate = $request->to_date;

                // Filter by the date range
                $visitQuery->whereBetween('date_of_visit', [$fromDate, $toDate]);
            } catch (\Exception $e) {
                // Error handling for invalid date format
                return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
            }
        }

        // Filter by visit type (New Meeting or Follow-up)
        if ($request->filled('visit_type')) {
            $visitType = $request->visit_type;
            if ($visitType === 'New Meeting') {
                $visitQuery->where('visit_type', 1); // New Meeting => 1
            } elseif ($visitType === 'Follow-up') {
                $visitQuery->where('visit_type', 0); // Follow-up => 0
            }
        }
    }]);

    // If the 'today_visit' parameter is set, filter by today's date
    if ($request->has('today_visit') && $request->today_visit == 'today') {
        $query->whereDate('created_at', '=', Carbon::today());
    }

    // Get the enquiries and the total count of visits
    $enquiries = $query->get();
    $enquiryCount = $query->withCount('visits')->count();
    $users = User::select('id', 'name', 'created_at')
    ->where('type',0)
    ->orderBy('id', 'asc')
    ->get();
    return view('admin.enquiry.admin_visit_record', compact('enquiries', 'enquiryCount','users'));
}



public function crm(Request $request)
{
    $users = User::select('id', 'name', 'created_at') // assuming 'dob' exists in 'users' table
                 ->orderBy('id', 'asc')
                 ->where('type',0)
                 ->get();

    $noDataFound = $users->isEmpty();
    $totalCount = $users->count();

    return view('admin.follow_up.crm_admin', compact('users', 'noDataFound','totalCount'));
}
    public function follow_up(Request $request)
    {
        $query = Enquiry::query()->with([
            'visits' => function ($visitQuery) use ($request) {
                $visitQuery->where('follow_up_date', '<>', 'n/a');
    
                $today = Carbon::now('Asia/Kolkata')->toDateString();
    
                // Show only today's & future follow-up dates
                $visitQuery->where('follow_up_date', '>=', $today);
    
                // If a date range is provided, filter visits by follow_up_date
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
            // Eager load the 'user' relationship on both visits and enquiries
            'user',  // Assuming Enquiry has a 'user' relationship
        ]);
    
        // Fetch the enquiries
        $enquiries = $query->get();
    
        // Check if any data exists
        $noDataFound = $enquiries->isEmpty() || $enquiries->every(fn($enquiry) => $enquiry->visits->isEmpty());
    
        // Prepare CRM user names for each enquiry
        foreach ($enquiries as $enquiry) {
            // Attach CRM user details for the enquiry
            $enquiry->crm_user_name = $enquiry->user ? $enquiry->user->name : null;
    
            // Attach CRM user details for each visit
            foreach ($enquiry->visits as $visit) {
                $visit->crm_user_name = $visit->user ? $visit->user->name : null;
            }
        }
    
        // Return the view with the data
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
    // Load enquiries with their latest visit where status is 1 or 2
    $enquiries = Enquiry::with([
        'visits' => function ($visitQuery) {
            $visitQuery->whereIn('update_status', [1, 2])
                       ->orderByDesc('date_of_visit') 
                       ->limit(1);
        },
        'user',  
    ])->get();
    
    // Filter to keep only enquiries that have at least one visit matching the conditions
    $filteredEnquiries = $enquiries->filter(function ($enquiry) {
        return $enquiry->visits->isNotEmpty();  // Only keep enquiries with a valid visit
    });
    
    // Process CRM user names for both enquiry and latest visit
    foreach ($filteredEnquiries as $enquiry) {
        $enquiry->crm_user_name = optional($enquiry->user)->name;  // CRM user name from the enquiry
        
        $latestVisit = $enquiry->visits->first();  // Get the latest visit (it should be only one)
        if ($latestVisit) {
            $latestVisit->crm_user_name = optional($latestVisit->user)->name;  // CRM user name from the visit
        }
    }

    // Count how many enquiries have at least one visit with status 1 or 2
    $totalCount = $filteredEnquiries->count();
    
    // Check if no data was found (i.e., no valid visits with status 1 or 2)
    $noDataFound = $filteredEnquiries->isEmpty();

    // Return the data to the view
    return view('admin.follow_up.pending_request', [
        'enquiries' => $filteredEnquiries,
        'totalCount' => $totalCount,
        'noDataFound' => $noDataFound,
    ]);
}

    

  
    public function updateVisitStatus(Request $request)
    {
       
        // Validate the request data
        $request->validate([
            'enquiry_id' => 'required|exists:enquiries,id',  // Ensure the visit exists in the database
            'status' => 'required|in:0,1,2',  // Status must be one of 0 (running), 1 (converted), or 3 (rejected)
        ]);

        // Find the visit
        $enquiry = Enquiry::findOrFail($request->enquiry_id);

        // Update the status
        $enquiry->status = $request->status;
        $enquiry->save();

        // Redirect or return success message
        return redirect()->back()->with('success', 'Request status updated successfully.');
    }
}
