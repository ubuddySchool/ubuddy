<?php
// app/Http/Controllers/EnquiryController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Enquiry;
use App\Models\Poc;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Datatables;

class EnquiryController extends Controller
{
    public function add()
    {
        return view('user.enquiry.add');
    }

    public function edit($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        return view('user.enquiry.edit', compact('enquiry'));
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
            'town' => 'required',
            'current_software' => 'required',
            'students_count' => 'required',
            'website' => 'required',
            'remarks' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/enquiries'), $filename);
                $imagePaths[] = 'uploads/enquiries/' . $filename;
            }
        }




        // Create new enquiry object
        $enquiry = new Enquiry();
        $enquiry->user_id = Auth::id();
        $enquiry->school_name = $request->school_name;
        $enquiry->board = $request->board;
        $enquiry->other_board_name = $request->other_board_name;
        $enquiry->address = $request->address;
        $enquiry->pincode = $request->pincode;
        $enquiry->town = $request->town;
        $enquiry->city = $request->city;
        $enquiry->state = $request->state;
        $enquiry->country = $request->country;
        $enquiry->website = $request->website;
        $enquiry->website_url = $request->website_url;
        $enquiry->students_count = $request->students_count;
        $enquiry->current_software = $request->current_software;
        $enquiry->software_details = $request->software_details;
        $enquiry->remarks = $request->remarks;
        $enquiry->images = json_encode($imagePaths);

        $enquiry->save();
        return redirect()->route('home')->with('success', 'Enquiry created successfully');
    }


    public function deleteImage($enquiryId, $index)
    {
        $enquiry = Enquiry::findOrFail($enquiryId);

        // Decode the JSON images column
        $images = json_decode($enquiry->images, true);

        if (!isset($images[$index])) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        $imagePath = public_path($images[$index]);

        // Delete file from storage if it exists
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Remove the image path from the array
        unset($images[$index]);

        // Re-index array and save updated JSON
        $enquiry->images = json_encode(array_values($images));
        $enquiry->save();

        return response()->json(['success' => 'Image deleted successfully.']);
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
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $enquiry = Enquiry::findOrFail($id);
    
        // Update all fields
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
    
        $existingImages = json_decode($enquiry->images ?? '[]', true);
        $imagePaths = $existingImages ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('uploads/enquiries');
                     if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0775, true);
                    }

                    $image->move($destinationPath, $filename);
        
                  
                    $imagePaths[] = 'uploads/enquiries/' . $filename;
                }
            }
        }
        
    
        // ✅ Save image paths
        $enquiry->images = json_encode($imagePaths);
    
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







    // public function addvisit(Request $request, $id)
    // {


    //     $request->validate([
    //         'date_of_visit' => 'required',
    //         'visit_remarks' => 'required|string|max:255',
    //         'update_flow' => 'required|string',
    //         'contact_method' => 'required|string',
    //         'update_status' => 'required|string',
    //         'follow_up_date' => 'required',
    //         'poc_ids' => 'required', 
    //         'hour_of_visit' => 'required|numeric|min:1|max:12',
    //         'minute_of_visit' => 'required|numeric|min:0|max:59',
    //         'am_pm' => 'required|in:AM,PM',
    //     ]);

    //     $hour = str_pad($request->input('hour_of_visit'), 2, '0', STR_PAD_LEFT);
    //     $minute = str_pad($request->input('minute_of_visit'), 2, '0', STR_PAD_LEFT);
    //     $am_pm = $request->input('am_pm');

    //     if ($am_pm == 'PM' && $hour != '12') {
    //         $hour = str_pad($hour + 12, 2, '0', STR_PAD_LEFT);
    //     } elseif ($am_pm == 'AM' && $hour == '12') {
    //         $hour = '00';
    //     }

    //     $time_of_visit = "{$hour}:{$minute}{$am_pm}";
    //     // $pocss_id = json_encode($request->poc_ids);
    //     $pocss_id = $request->poc_ids ? array_map('intval', $request->poc_ids) : [];

    //     // $pocss_id = $request->poc_ids;


    //     Visit::create([
    //         'user_id' => auth()->id(),
    //         'enquiry_id' => $id,
    //         'date_of_visit' =>  $request->date_of_visit,
    //         'time_of_visit' => $time_of_visit,
    //         'visit_remarks' => $request->visit_remarks,
    //         'update_flow' => $request->update_flow,
    //         'contact_method' => $request->contact_method,
    //         'update_status' => $request->update_status,
    //         'follow_up_date' =>  $request->follow_up_date,
    //         'poc_ids' =>  $pocss_id,
    //     ]);

    //     return redirect()->back()->with('success', 'Visit added successfully!');
    // }

    public function addvisit(Request $request, $id)
    {
        // Validate the request if needed (uncomment and modify the validation rules as needed)
        // $request->validate([
        //     'date_of_visit' => 'required',
        //     'visit_remarks' => 'required|string|max:255',
        //     'update_flow' => 'required|string',
        //     'contact_method' => 'required|string',
        //     'update_status' => 'required|string',
        //     'follow_up_date' => 'required',
        //     'poc_ids' => 'required', 
        //     'hour_of_visit' => 'required|numeric|min:1|max:12',
        //     'minute_of_visit' => 'required|numeric|min:0|max:59',
        //     'am_pm' => 'required|in:AM,PM',
        // ]);

        // Format date_of_visit as 'Y-m-d'
        $date_of_visit = \Carbon\Carbon::now()->format('Y-m-d');

        // Handle follow_up_date logic
        if ($request->follow_up_date == 'n/a') {
            $follow_up_date = null;
            $follow_na = 'n/a';
        } else {
            $follow_up_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->follow_up_date)->format('Y-m-d');
            $follow_na = null;
        }

        // Prepare time_of_visit
        $hour = str_pad($request->input('hour_of_visit'), 2, '0', STR_PAD_LEFT);
        $minute = str_pad($request->input('minute_of_visit'), 2, '0', STR_PAD_LEFT);
        $am_pm = $request->input('am_pm');

        // Convert to 24-hour format
        if ($am_pm == 'PM' && $hour != '12') {
            $hour = str_pad($hour + 12, 2, '0', STR_PAD_LEFT);
        } elseif ($am_pm == 'AM' && $hour == '12') {
            $hour = '00';
        }

        $time_of_visit = "{$hour}:{$minute}:{$am_pm}"; // 24-hour format

        // Prepare POC IDs
        $pocss_id = $request->poc_ids ? array_map('intval', $request->poc_ids) : [];

        // Check if the enquiry_id already exists in the visits table
        $existingVisit = Visit::where('enquiry_id', $id)->first();

        // Set visit_type based on the existence of the enquiry_id
        $visit_type = $existingVisit ? 0 : 1; // If exists, set visit_type = 0; if not, set visit_type = 1

        // Create the new visit record
        Visit::create([
            'user_id' => auth()->id(),
            'enquiry_id' => $id,
            'date_of_visit' => $date_of_visit,
            'time_of_visit' => $time_of_visit,
            'visit_remarks' => $request->visit_remarks,
            'update_flow' => $request->update_flow,
            'contact_method' => $request->contact_method,
            'update_status' => $request->update_status,
            'follow_up_date' => $follow_up_date,
            'follow_na' => $follow_na,
            'poc_ids' => $pocss_id,
            'visit_type' => $visit_type,
        ]);

        return redirect()->back()->with('success', 'Visit added successfully!');
    }
}
