<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\View\View;
use DataTables;
use Carbon\Carbon;
use App\Models\Enquiry;
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


    
public function follow_up(Request $request)
{
    $query = Enquiry::query();

    // Apply Date Range Filter
    if ($request->has('from_date') && $request->has('to_date')) {
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
        }
    }

    // Apply Expired Follow-Ups Filter (Those with a date before today)
    if ($request->has('expiry_filter') && $request->expiry_filter == 'expired') {
        $query->whereDate('created_at', '<', Carbon::today());
    }

    $enquiries = $query->get();

    return view('user.followup.index', compact('enquiries'));
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

        // Apply filters if they exist
        if ($request->has('city') && $request->city != '') {
            $data->where('city', $request->city);
        }

        if ($request->has('status') && $request->status != '') {
            $data->where('status', $request->status);
        }

        if ($request->has('flow') && $request->flow != '') {
            $data->where('remarks', $request->flow);
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

   // Get distinct status values
   $statuses = Enquiry::distinct()->pluck('status');

   // Map the numeric values to their readable labels
   $statusLabels = [
       0 => 'Running',
       1 => 'Converted',
       2 => 'Rejected'
   ];

   // Filter statuses to show only those that exist in the database
   $filteredStatuses = [];
   foreach ($statuses as $status) {
       if (isset($statusLabels[$status])) {
           $filteredStatuses[$status] = $statusLabels[$status];
       }
   }
    $enquiries = Enquiry::all();
    $cities = Enquiry::distinct()->pluck('city');  // Assuming 'city' is the column name
    // $statuses = Enquiry::distinct()->pluck('status');  // Assuming 'status' is the column name
    $flows = Enquiry::distinct()->pluck('remarks');  // Assuming 'current_flow' is the column name

    return view('home', compact('cities', 'filteredStatuses', 'flows','enquiries'));
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
