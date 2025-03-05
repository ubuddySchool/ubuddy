<?php
// app/Http/Controllers/EnquiryController.php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Datatables;
class EnquiryController extends Controller
{
    public function add(){
        return view('user.enquiry.add');
    }
   
    public function edit($id){
        $enquiry = Enquiry::findOrFail($id);
        return view('user.enquiry.edit',compact('enquiry'));
    }



   public function store(Request $request)
   {
       // Validate the incoming request data
       $validated = $request->validate([
           'school_name' => 'required|string',
           'board' => 'required|string',
           'address' => 'required|string',
           'pincode' => 'required|string',
           'city' => 'required|string',
           'state' => 'required|string',
           'current_software' => 'required',
       ]);
   
       $enquiry = new Enquiry();
       $enquiry->user_id = Auth::id(); 
       $enquiry->school_name = $request->school_name;
       $enquiry->board = $request->board;
       $enquiry->other_board_name = $request->other_board_name;
       $enquiry->address = $request->address;
       $enquiry->pincode = $request->pincode;
       $enquiry->city = $request->city;
       $enquiry->state = $request->state;
       $enquiry->country = $request->country;
       $enquiry->website = $request->website;
       $enquiry->website_url = $request->website_url;
       $enquiry->students_count = $request->students_count;
       $enquiry->current_software = $request->current_software;
       $enquiry->software_details = $request->software_details;
       $enquiry->remarks = $request->remarks;
       $enquiry->poc_name = $request->poc_name;
       $enquiry->poc_designation = $request->poc_designation;
       $enquiry->poc_contact = $request->poc_contact;
   
       // Save the Enquiry
       $enquiry->save();
   
       return redirect()->route('home')->with('success', 'Enquiry created successfully');
   }

   public function update(Request $request, $id)
   {
       $validated = $request->validate([
           'school_name' => 'required|string',
           'board' => 'required|string',
           'address' => 'required|string',
           'pincode' => 'required|string',
           'city' => 'required|string',
           'state' => 'required|string',
           'current_software' => 'required',
       ]);
   
       $enquiry = Enquiry::findOrFail($id);
   
     
       $enquiry->user_id = Auth::id(); 
   
       $enquiry->school_name = $request->school_name;
       $enquiry->board = $request->board;
       $enquiry->other_board_name = $request->other_board_name;
       $enquiry->address = $request->address;
       $enquiry->pincode = $request->pincode;
       $enquiry->city = $request->city;
       $enquiry->state = $request->state;
       $enquiry->country = $request->country;
       $enquiry->website = $request->website;
       $enquiry->website_url = $request->website_url;
       $enquiry->students_count = $request->students_count;
       $enquiry->current_software = $request->current_software;
       $enquiry->software_details = $request->software_details;
       $enquiry->remarks = $request->remarks;
       $enquiry->poc_name = $request->poc_name;
       $enquiry->poc_designation = $request->poc_designation;
       $enquiry->poc_contact = $request->poc_contact;
   
       $enquiry->save();
   
       return redirect()->route('enquiries.index')->with('success', 'Enquiry updated successfully');
   }
   
   





    
}
