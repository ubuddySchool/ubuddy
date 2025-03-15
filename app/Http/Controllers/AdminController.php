<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Enquiry;

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
    
            
$data->leftJoin('users', 'enquiries.user_id', '=', 'users.id')
     ->select('enquiries.*', 'users.name as crm_name');
   


            $data->orderByDesc('enquiries.created_at'); // Ensure that the most recent enquiries come first
    
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('last_visit', function($row) {
                    $lastVisit = $row->visits->first(); // Fetch the latest visit
                    if ($lastVisit) {
                        return $lastVisit->date_of_visit . ' ' . $lastVisit->time_of_visit;
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
                        return $lastVisit->follow_up_date;
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
        $crms = User::where('type', 0)->pluck('name', 'id')->toArray(); // Only fetch users with type 0
    
        return view('admin.adminindex', compact('cities', 'statuses', 'flows', 'crms', 'enquiries'));
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
    
    public function pending_request(Request $request)
    {
        $query = Enquiry::query()->with([
            'visits' => function ($visitQuery) use ($request) {
                // Check for follow_up_date or follow_na (if follow_up_date is null)
                $visitQuery->where(function ($query) {
                    $query->whereNotNull('follow_up_date')
                          ->orWhereNotNull('follow_na');
                });
    
                $today = Carbon::now('Asia/Kolkata')->toDateString();
    
                // Show only today's & future follow-up dates or follow_na
                $visitQuery->where(function ($query) use ($today) {
                    $query->where('follow_up_date', '>=', $today)
                          ->orWhere('follow_na', '>=', $today);
                });
    
                // If a date range is provided, filter visits by follow_up_date or follow_na
                if ($request->filled('from_date') && $request->filled('to_date')) {
                    try {
                        $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->toDateString();
                        $toDate   = Carbon::createFromFormat('Y-m-d', $request->to_date)->toDateString();
    
                        $visitQuery->where(function ($query) use ($fromDate, $toDate) {
                            $query->whereBetween('follow_up_date', [$fromDate, $toDate])
                                  ->orWhereBetween('follow_na', [$fromDate, $toDate]);
                        });
                    } catch (\Exception $e) {
                        return back()->withErrors(['date_format' => 'Invalid date format. Please use YYYY-MM-DD.']);
                    }
                }
    
                // Get the latest visit based on date_of_visit
                $visitQuery->orderByDesc('date_of_visit')->take(1); // Sort by date_of_visit descending and take the latest visit
            },
            // Eager load the 'user' relationship on both visits and enquiries
            'user',  // Assuming Enquiry has a 'user' relationship
        ]);
    
        // Fetch the enquiries
        $enquiries = $query->get();
    
        // Check if any data exists
        $noDataFound = $enquiries->isEmpty() || $enquiries->every(fn($enquiry) => $enquiry->visits->isEmpty());
    
        // Prepare CRM user names for each enquiry and show only the latest visit
        foreach ($enquiries as $enquiry) {
            // Attach CRM user details for the enquiry
            $enquiry->crm_user_name = $enquiry->user ? $enquiry->user->name : null;
    
            // Show only the latest visit
            if ($enquiry->visits->isNotEmpty()) {
                $latestVisit = $enquiry->visits->first();  // Get the latest visit
                $latestVisit->crm_user_name = $latestVisit->user ? $latestVisit->user->name : null;
            }
        }
    
        // Return the view with the data
        return view('admin.follow_up.pending_request', compact('enquiries', 'noDataFound'));
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
