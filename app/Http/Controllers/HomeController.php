<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\View\View;
use DataTables;
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
    public function follow_up(): View
    {
        $enquiries = Enquiry::all(); 

        return view('user.followup.index',compact('enquiries'));
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
    
public function last_follow()
{
    $enquiries = Enquiry::query(); // or use whatever model you want

    return DataTables::of($enquiries)
        ->addColumn('action', function ($row) {
            return '<button class="btn btn-sm btn-primary">Edit</button>'; // or any custom HTML
        })
        ->make(true);
}
  
  
   
}
