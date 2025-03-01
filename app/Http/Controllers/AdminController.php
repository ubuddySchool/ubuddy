<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;
class AdminController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminHome(Request $request)
    {
        if ($request->ajax()) {
            $query = Enquiry::query();
    
           
            if ($request->has('search') && $request->search['value'] != '') {
                $search = $request->search['value'];
    
                $query->where(function ($query) use ($search) {
                    $query->whereRaw('LOWER(enquiries.school_name) LIKE ?', ['%' . strtolower($search) . '%'])
                          ->orWhereRaw('LOWER(enquiries.city) LIKE ?', ['%' . strtolower($search) . '%']);
                         
                });
                
            }
            
    
            return Datatables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    
        return view('admin.adminindex');
    }
    
    
}
