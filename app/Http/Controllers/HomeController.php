<?php
  
namespace App\Http\Controllers;
  
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

        return view('home',compact('enquiries'));
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
    $query = Enquiry::query()->with(['visits' => function ($visitQuery) use ($request) {
        if ($request->filled('from_date') && $request->filled('to_date')) {
            try {
                // Validate the 'from_date' and 'to_date' inputs are in dd-mm-yyyy format
                $fromDate = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
                $toDate = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');
                
                // Filter by the date range with the correct format
                $visitQuery->whereBetween('date_of_visit', [$fromDate, $toDate]);
            } catch (\Exception $e) {
                // Error handling for invalid date format
                return back()->withErrors(['date_format' => 'Invalid date format. Please use DD-MM-YYYY.']);
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
        $data = Enquiry::query();

        // Apply filters if they exist
        if ($request->has('city') && $request->city != '') {
            $data->where('city', $request->city);
        }

        if ($request->has('status') && $request->status != '') {
            $data->where('status', $request->status);
        }

        // Filter by last visit's update_flow
        if ($request->has('flow') && $request->flow != '') {
            $data->whereHas('visits', function($query) use ($request) {
                // Fetch the most recent visit and apply the filter
                $query->latest()->take(1);  // Ensure we are looking at the latest visit
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

        // Order the Enquiry records by created_at in descending order (newest first)
        $data->orderByDesc('created_at'); // Ensure that the most recent enquiries come first

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('last_visit', function($row) {
                $lastVisit = $row->visits->first(); // Fetch the latest visit
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
            
                // Check if follow_up_date is not null and format it as dd-mm-yyyy
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

    return view('home', compact('cities', 'statuses', 'flows','enquiries'));
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
