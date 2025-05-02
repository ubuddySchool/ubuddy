<?php

namespace App\Http\Controllers;

use App\Models\Poc;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DataTables;
use Carbon\Carbon;
use App\Models\Enquiry;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        $enquiries = Enquiry::all();

        return view('home', compact('enquiries'));
    }





    // public function follow_up(Request $request)
    // {
    //     $query = Enquiry::query();

    //     // Apply Date Range Filter
    //     if ($request->has('from_date') && $request->has('to_date')) {
    //         if (!empty($request->from_date) && !empty($request->to_date)) {
    //             $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
    //         }
    //     }

    //     // Apply Expired Follow-Ups Filter (Those with a date before today)
    //     if ($request->has('expiry_filter') && $request->expiry_filter == 'expired') {
    //         $query->whereDate('created_at', '<', Carbon::today());
    //     }

    //     $enquiries = $query->get();

    //     return view('user.followup.index', compact('enquiries'));
    // }
    public function follow_up(Request $request)
    {
        // Get the authenticated user's ID
        $userId = auth()->id();
    
        // Build the query
        $query = Enquiry::query()->with(['visits' => function ($visitQuery) use ($request, $userId) {
            // Always filter out visits with follow_up_date equal to "n/a"
            $visitQuery->where('follow_up_date', '<>', 'n/a');
    
            // Filter visits based on the authenticated user
            $visitQuery->where('user_id', $userId);
    
            // Get today's date
            $today = Carbon::now('Asia/Kolkata')->toDateString();
    
            // Show only today's & future follow-up dates
            $visitQuery->where('follow_up_date', '>=', $today);
    
            // Apply the filters if dates are provided
            if ($request->filled('from_date') && $request->filled('to_date')) {
                try {
                    $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->toDateString();
                    $toDate   = Carbon::createFromFormat('Y-m-d', $request->to_date)->toDateString();
    
                    // Filter based on both from_date and to_date
                    $visitQuery->whereBetween('follow_up_date', [$fromDate, $toDate]);
                } catch (\Exception $e) {
                    return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
                }
            } elseif ($request->filled('from_date')) {
                try {
                    // If only from_date is filled, filter based on from_date
                    $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->toDateString();
                    $visitQuery->where('follow_up_date', '=', $fromDate);
                } catch (\Exception $e) {
                    return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
                }
            } elseif ($request->filled('to_date')) {
                try {
                    // If only to_date is filled, filter based on to_date
                    $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->toDateString();
                    $visitQuery->where('follow_up_date', '=', $toDate);
                } catch (\Exception $e) {
                    return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
                }
            }
        }]);
    
        // Filter enquiries based on the authenticated user
        $query->where('user_id', $userId);
    
        // Execute the query
        $enquiries = $query->get();
    
        // Check if any data exists
        $noDataFound = $enquiries->isEmpty() || $enquiries->every(fn($enquiry) => $enquiry->visits->isEmpty());
    
        // Format the 'follow_up_date' to dd-mm-yyyy format for each visit
        foreach ($enquiries as $enquiry) {
            foreach ($enquiry->visits as $visit) {
                // Convert to dd-mm-yyyy format
                $visit->follow_up_date = Carbon::parse($visit->follow_up_date)->format('d-m-Y');
            }
        }
    
        // If AJAX request, return filtered data as JSON
        if ($request->ajax()) {
            return response()->json([
                'enquiries' => $enquiries,
                'noDataFound' => $noDataFound,
            ]);
        }
    
        // For non-AJAX requests, return the full page view
        return view('user.followup.index', compact('enquiries', 'noDataFound'));
    }
    

    public function visit_record(Request $request)
    {
        $userId = auth()->user()->id;
    
        $query = Enquiry::where('user_id', $userId)
            ->with(['visits' => function ($visitQuery) use ($request) {
                // If both from_date and to_date are provided, filter by date range.
                if ($request->filled('from_date') && $request->filled('to_date')) {
                    try {
                        $fromDate = $request->from_date;
                        $toDate = $request->to_date;
                        // Filter by date range
                        $visitQuery->whereBetween('date_of_visit', [$fromDate, $toDate]);
                    } catch (\Exception $e) {
                        return response()->json(['error' => 'Invalid date format. Please use YYYY-MM-DD.'], 400);
                    }
                }
                // If only from_date is provided, filter by that date (exact match).
                elseif ($request->filled('from_date')) {
                    try {
                        $fromDate = $request->from_date;
                        $visitQuery->whereDate('date_of_visit', '=', $fromDate);
                    } catch (\Exception $e) {
                        return response()->json(['error' => 'Invalid from_date format.'], 400);
                    }
                }
                // If only to_date is provided, filter by that date (less than or equal).
                elseif ($request->filled('to_date')) {
                    try {
                        $toDate = $request->to_date;
                        $visitQuery->whereDate('date_of_visit', '<=', $toDate);
                    } catch (\Exception $e) {
                        return response()->json(['error' => 'Invalid to_date format.'], 400);
                    }
                }
    
                // Filter by visit type
                if ($request->filled('visit_type')) {
                    $visitType = $request->visit_type;
                    if ($visitType === 'New Meeting') {
                        $visitQuery->where('visit_type', 1);
                    } elseif ($visitType === 'Follow-up') {
                        $visitQuery->where('visit_type', 0);
                    }
                }
    
                // Filter by contact method
                if ($request->filled('contact_method')) {
                    $contactMethod = $request->contact_method;
                    if ($contactMethod == 1 || $contactMethod == 0) {
                        $visitQuery->where('contact_method', $contactMethod);
                    }
                }
    
                // Filter for today's visits only
                if ($request->has('today_visit') && $request->today_visit === 'today') {
                    $visitQuery->whereDate('date_of_visit', \Carbon\Carbon::today());
                }
            }]);
    
        $enquiries = $query->get();
    
        // If the request is AJAX, return the data as JSON
        if ($request->ajax()) {
            return response()->json([
                'enquiries' => $enquiries,
                'rowNumber' => 1, // You can adjust the row numbering logic if necessary
            ]);
        }
    
        // For regular page load (non-AJAX), return the view
        return view('user.enquiry.visit_record', compact('enquiries'));
    }
    
    
public function expired_follow_up(Request $request)
    {
        $query = Enquiry::query()->with(['visits' => function ($visitQuery) use ($request) {
            $visitQuery->where('follow_up_date', '<>', 'n/a');
    
            $now = Carbon::now('Asia/Kolkata');
    
            if ($now->hour >= 12) {
                $visitQuery->where('follow_up_date', '<=', $now->toDateString());
            } else {
                $visitQuery->where('follow_up_date', '<', $now->toDateString());
            }
    
            // Date range filter
            if ($request->filled('from_date') && $request->filled('to_date')) {
                try {
                    $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('Y-m-d');
                    $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('Y-m-d');
                    $visitQuery->whereBetween('follow_up_date', [$fromDate, $toDate]);
                } catch (\Exception $e) {
                    return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
                }
            } elseif ($request->filled('from_date')) {
                try {
                    $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('Y-m-d');
                    $visitQuery->where('follow_up_date', '=', $fromDate);
                } catch (\Exception $e) {
                    return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
                }
            } elseif ($request->filled('to_date')) {
                try {
                    $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('Y-m-d');
                    $visitQuery->where('follow_up_date', '=', $toDate);
                } catch (\Exception $e) {
                    return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
                }
            }
        }]);
    
        // Execute the query and retrieve the results
        $enquiries = $query->get();
    
        // Check if any data exists
        $noDataFound = $enquiries->isEmpty() || $enquiries->every(fn($enquiry) => $enquiry->visits->isEmpty());
    
        // Format the 'follow_up_date' to dd-mm-yyyy format for each visit
        foreach ($enquiries as $enquiry) {
            foreach ($enquiry->visits as $visit) {
                $visit->follow_up_date = Carbon::parse($visit->follow_up_date)->format('d-m-Y');
            }
        }
    
        // If it's an AJAX request, return the filtered data as JSON
        if ($request->ajax()) {
            return response()->json([
                'enquiries' => $enquiries,
                'noDataFound' => $noDataFound,
            ]);
        }
    
        // Return the full page if it's not an AJAX request
        return view('user.enquiry.expired_follow', compact('enquiries', 'noDataFound'));
    }
    




    public function last_follows(Request $request)
    {
        $enquiries = Enquiry::query();

        if ($request->has('expiry_filter')) {
            if ($request->expiry_filter == 'expired') {
                $enquiries = $enquiries->where('updated_at', '<', now());
            } elseif ($request->expiry_filter == 'not_expired') {
                $enquiries = $enquiries->where('updated_at', '>=', now());
            }
        }

        if (!$request->has('expiry_filter') || $request->expiry_filter == 'not_expired') {
            $enquiries = Enquiry::all();
        }

        $enquiries = $enquiries->get();



        return view('home', compact('enquiries'));
    }

    // public function last_follow(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Enquiry::query();

    //         // Apply filters if they exist (same as dynamic filter logic)
    //         if ($request->has('city') && $request->city != '') {
    //             $data->where('city', $request->city);
    //         }

    //         if ($request->has('status') && $request->status != '') {
    //             $data->where('status', $request->status);
    //         }

    //         if ($request->has('flow') && $request->flow != '') {
    //             $data->where('remarks', $request->flow); // Filter by 'remarks' for Flow
    //         }

    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('action', function($row) {
    //                 $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     // Get distinct values for filters (you can remove or adjust this logic)
    //     $enquiries = Enquiry::all();
    //     $cities = Enquiry::distinct()->pluck('city');
    //     $flows = ['0' => 'Visited', '1' => 'Meeting Done', '2' => 'Demo Given']; // Static flow options
    //     $statuses = ['0' => 'Running', '1' => 'Converted', '2' => 'Rejected']; // Static status options

    //     return view('home', compact('cities', 'statuses', 'flows','enquiries'));
    // }

    public function last_follow(Request $request)
    {
        if ($request->ajax()) {
            $userId = auth()->user()->id;

            $data = Enquiry::query();

            $data->where('user_id', $userId);

            // Apply filters if they exist
            if ($request->has('city') && $request->city != '') {
                $data->where('city', $request->city);
            }

            // if ($request->has('status') && $request->status != '') {
            //     $data->where('status', $request->status);
            // }

            if ($request->has('status') && $request->status != '') {
                $data->whereIn('id', function ($query) use ($request) {
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


            $data->with(['visits' => function ($query) {
                $query->latest()->take(1); 
            }]);


            $data->orderByDesc('created_at');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('last_visit', function ($row) {
                    $lastVisit = $row->visits->first();
                    if ($lastVisit) {
                        return \Carbon\Carbon::parse($lastVisit->date_of_visit)->format('d-m-Y');
                    }
                    return 'N/A';
                })

                ->addColumn('visit_remarks', function ($row) {
                    $lastVisit = $row->visits->first();
                    return $lastVisit ? $lastVisit->visit_remarks : 'No Remarks';
                })
                ->addColumn('follow_up_date', function ($row) {
                    $lastVisit = $row->visits->first();

                    if ($lastVisit && $lastVisit->follow_up_date) {
                        return \Carbon\Carbon::parse($lastVisit->follow_up_date)->format('d-m-Y');
                    }

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
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status', 'update_status'])
                ->make(true);
        }

        $userId = auth()->user()->id;
        $enquiries = Enquiry::where('user_id', $userId)->get();

        $cities = Enquiry::where('user_id', $userId)->distinct()->pluck('city');

        $statuses = ['0' => 'Running', '1' => 'Converted', '2' => 'Rejected', '3' => 'R-Converted', '4' => 'R-Rejected'];

        return view('home', compact('cities', 'statuses', 'enquiries'));
    }

    public function add_visit(Request $request, $id)
    {
        $id = intval($id);
        $enquiry = Enquiry::where('id', $id)->first(); // Changed get() to first()


        return view('user.action_new.add_visit', compact('enquiry'));
    }

    public function view_details(Request $request, $id)
    {
        $id = intval($id);
        $enquiries = Enquiry::where('id', $id)->get();

        return view('user.action_new.details', compact('enquiries'));
    }
    public function edit_enquiry(Request $request, $id)
    {
        $id = intval($id);
        $enquiries = Enquiry::where('id', $id)->get();

        return view('user.enquiry.edit', compact('enquiries'));
    }

    public function poclist(Request $request)
    {
        $rawQuery = $request->getQueryString(); // returns "3"
        $id = intval($rawQuery);
        $pocs = Poc::where('enquiry_id', $id)->get();

        return view('user.poc.poclist', compact('pocs', 'id'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'poc_name' => 'required|string|max:255',
            'poc_designation' => 'required|string|max:255',
            'poc_number' => 'required|digits:10',
        ]);

        $poc = Poc::findOrFail($id);
        $poc->update($request->only('poc_name', 'poc_designation', 'poc_number'));

        return redirect()->route('poclist', [$poc->enquiry_id])->with('success', 'POC updated successfully!');
    }






    // public function updateRemark(Request $request, $id)
    // {
    //     $request->validate([
    //         'remarks' => 'required|string|max:255', 
    //     ]);


    //     $enquiry = Visit::find($id);

    //     if ($enquiry) {
    //         $enquiry->expired_remarks = $request->input('expired_remarks');
    //         $enquiry->save();
    //          return redirect()->back()->with('success', 'Remark updated successfully!');
    //     }

    //     return redirect()->back()->with('error', 'Enquiry not found!');
    // }


    public function updateRemark(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:500',
        ]);

        $visit = Visit::findOrFail($id);
        $visit->expired_remarks = $request->remarks;
        $visit->save();

        return redirect()->back()->with('success', 'Remark updated successfully!');
    }
}
