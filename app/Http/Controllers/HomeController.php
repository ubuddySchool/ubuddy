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

        // Return the view
        return view('user.followup.index', compact('enquiries', 'noDataFound'));
    }
    public function visit_record(Request $request)
    {
        // Get the authenticated user's ID
        $userId = auth()->user()->id;

        // Start the query with the user_id filter
        $query = Enquiry::where('user_id', $userId)  // Only fetch enquiries belonging to the authenticated user
            ->with(['visits' => function ($visitQuery) use ($request) {
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

        return view('user.enquiry.visit_record', compact('enquiries', 'enquiryCount'));
    }




    public function expired_follow_up(Request $request)
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
                $query->latest()->take(1); // Take only the most recent visit
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
