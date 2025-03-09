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
    
   

    
    // public function follow_up(): View
    // {
    //     $enquiries = Enquiry::all(); 

    //     return view('user.followup.index',compact('enquiries'));
    // } 


    
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
    $query = Enquiry::query()->with(['visits' => function ($visitQuery) use ($request) {
        // Always filter out visits with follow_up_date equal to "n/a"
        $visitQuery->where('follow_up_date', '<>', 'n/a');

        // If a date range is provided, filter visits by date_of_visit (stored as string in DD-MM-YYYY)
        if ($request->filled('from_date') && $request->filled('to_date')) {
            try {
                // Convert input from YYYY-MM-DD (HTML input) to DD-MM-YYYY (database format)
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('d-m-Y');
                $toDate   = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('d-m-Y');

                $visitQuery->whereBetween('date_of_visit', [$fromDate, $toDate]);
            } catch (\Exception $e) {
                return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
            }
        }
    }]);

    // Optional: Apply Expired Follow-Ups Filter on the Enquiry's created_at
    if ($request->has('expiry_filter') && $request->expiry_filter == 'expired') {
        $query->whereDate('created_at', '<', Carbon::today());
    }

    $enquiries = $query->get();

    return view('user.followup.index', compact('enquiries'));
}

public function visit_record(Request $request)
{
    $query = Enquiry::query()->with(['visits' => function ($visitQuery) use ($request) {
        if ($request->filled('from_date') && $request->filled('to_date')) {
            try {
                // Convert 'YYYY-MM-DD' (input) to 'DD-MM-YYYY' (DB format)
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('d-m-Y');
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('d-m-Y');

                // Apply filter on visits (date stored as string)
                $visitQuery->whereBetween('date_of_visit', [$fromDate, $toDate]);
            } catch (\Exception $e) {
                return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
            }
        }
    }]);

    // Apply Expired Follow-Ups Filter
    if ($request->has('expiry_filter') && $request->expiry_filter == 'expired') {
        $query->whereDate('created_at', '<', Carbon::today());
    }

    $enquiries = $query->get();

    return view('user.enquiry.visit_record', compact('enquiries'));
}



    public function expired_follow_up(Request $request)
{
    $query = Enquiry::query()->with(['visits' => function ($visitQuery) use ($request) {
      
        $visitQuery->where('follow_up_date', '<>', 'n/a');

        if ($request->has('expiry_filter') && $request->expiry_filter == 'expired') {
            $today = Carbon::now()->format('d-m-Y'); 
            $visitQuery->where('follow_up_date', '<', $today);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            try {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('d-m-Y');
                $toDate   = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('d-m-Y');

                $visitQuery->whereBetween('date_of_visit', [$fromDate, $toDate]);
            } catch (\Exception $e) {
                return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
            }
        }
    }]);

    $enquiries = $query->get();

    return view('user.enquiry.expired_follow', compact('enquiries'));
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
// public function last_follow()
// {
//     $enquiries = Enquiry::select(['id', 'school_name', 'city', 'created_at', 'pincode', 'status'])
//                         ->get();

//     return DataTables::of($enquiries)
//         ->addIndexColumn() // This will automatically generate the index column (S No.)
//         ->addColumn('action', function ($row) {
//             return '<button class="btn btn-sm btn-primary">Edit</button>'; // Action column
//         })
//         ->rawColumns(['action']) // Ensures raw HTML is rendered in the 'action' column
//         ->make(true);
// }
public function last_follow(Request $request)
{
    if ($request->ajax()) {
        $data = Enquiry::query();

        // Apply filters if they exist (same as dynamic filter logic)
        if ($request->has('city') && $request->city != '') {
            $data->where('city', $request->city);
        }

        if ($request->has('status') && $request->status != '') {
            $data->where('status', $request->status);
        }

        if ($request->has('flow') && $request->flow != '') {
            $data->where('remarks', $request->flow); // Filter by 'remarks' for Flow
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Get distinct values for filters (you can remove or adjust this logic)
    $enquiries = Enquiry::all();
    $cities = Enquiry::distinct()->pluck('city');
    $flows = ['0' => 'Visited', '1' => 'Meeting Done', '2' => 'Demo Given']; // Static flow options
    $statuses = ['0' => 'Running', '1' => 'Converted', '2' => 'Rejected']; // Static status options

    return view('home', compact('cities', 'statuses', 'flows','enquiries'));
}



public function updateRemark(Request $request, $id)
{
    $request->validate([
        'remarks' => 'required|string|max:255', 
    ]);

   
    $enquiry = Enquiry::find($id);

    if ($enquiry) {
        $enquiry->remarks = $request->input('remarks');
        $enquiry->save();
         return redirect()->back()->with('success', 'Remark updated successfully!');
    }

    return redirect()->back()->with('error', 'Enquiry not found!');
}


  
   
}
