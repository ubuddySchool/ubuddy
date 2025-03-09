<?php
// app/Http/Controllers/EnquiryController.php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Enquiry;
use App\Models\Poc;
use App\Models\Visit;
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
        $validated = $request->validate([
            'school_name' => 'required|string',
            'board' => 'required|string',
            'address' => 'required|string',
            'pincode' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'current_software' => 'required',
        ]);
    
        // Create new enquiry object
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
    
        $enquiry->save();
        return redirect()->route('home')->with('success', 'Enquiry created successfully');
    }
    

    

    
    public function update(Request $request, $id)
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
        $enquiry->updated_at = now();
        
        $enquiry->save();
    
        return redirect()->route('home')->with('success', 'Enquiry updated successfully');
    }

        public function addpocs(Request $request, $id)
        {
            $validated = $request->validate([
                'poc_name' => 'required|string|max:255',
                'poc_designation' => 'required|string|max:255',
                'poc_number' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^\d{10}$/',
                ],
            ], [
                'poc_number.regex' => 'The phone number must be exactly 10 digits.',
            ]);
            

            $enquiry = Enquiry::findOrFail($id);
    
           
            $poc = new Poc();
            $poc->user_id = Auth::id();
            $poc->poc_name = $validated['poc_name'];
            $poc->poc_designation = $validated['poc_designation'];
            $poc->poc_number = $validated['poc_number'];
            $poc->enquiry_id = $enquiry->id; 
    
            $poc->save();
    
            return redirect()->back()->with('success', 'POC added successfully!');
        }
  






        public function addvisit(Request $request, $id)
        {
            
        
            $request->validate([
                'date_of_visit' => 'required',
                'visit_remarks' => 'required|string|max:255',
                'update_flow' => 'required|string',
                'contact_method' => 'required|string',
                'update_status' => 'required|string',
                'follow_up_date' => 'required',
                'poc_ids' => 'required', 
                'hour_of_visit' => 'required|numeric|min:1|max:12',
                'minute_of_visit' => 'required|numeric|min:0|max:59',
                'am_pm' => 'required|in:AM,PM',
            ]);
        
            $hour = str_pad($request->input('hour_of_visit'), 2, '0', STR_PAD_LEFT);
            $minute = str_pad($request->input('minute_of_visit'), 2, '0', STR_PAD_LEFT);
            $am_pm = $request->input('am_pm');
        
            if ($am_pm == 'PM' && $hour != '12') {
                $hour = str_pad($hour + 12, 2, '0', STR_PAD_LEFT);
            } elseif ($am_pm == 'AM' && $hour == '12') {
                $hour = '00';
            }
        
            $time_of_visit = "{$hour}:{$minute}{$am_pm}";
            // $pocss_id = json_encode($request->poc_ids);
            $pocss_id = $request->poc_ids ? array_map('intval', $request->poc_ids) : [];

            // $pocss_id = $request->poc_ids;
      
          
            Visit::create([
                'user_id' => auth()->id(),
                'enquiry_id' => $id,
                'date_of_visit' =>  $request->date_of_visit,
                'time_of_visit' => $time_of_visit,
                'visit_remarks' => $request->visit_remarks,
                'update_flow' => $request->update_flow,
                'contact_method' => $request->contact_method,
                'update_status' => $request->update_status,
                'follow_up_date' =>  $request->follow_up_date,
                'poc_ids' =>  $pocss_id,
            ]);
        
            return redirect()->back()->with('success', 'Visit added successfully!');
        }
        
}
