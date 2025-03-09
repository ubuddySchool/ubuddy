@foreach ($enquiries as $enquiry)
<div id="full-width-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullWidthModalLabel">Add Visit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('add.visit', $enquiry->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Date of Visit -->
                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="visit_date_{{ $enquiry->id }}">Date Of Visit <span class="login-danger">*</span></label>
                            <input class="form-control" name="date_of_visit" type="text" id="visit_date_{{ $enquiry->id }}" placeholder="DD-MM-YYYY" oninput="formatDate(this)" maxlength="10">
                        </div>

                        <!-- Time of Visit -->
                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="time_of_visit_{{ $enquiry->id }}">Time Of Visit <span class="login-danger">*</span></label>
                            <div class="d-flex">
                                <!-- Hour Dropdown -->
                                <select class="form-control me-2" name="hour_of_visit" style="max-width: 60px;" id="hour_of_visit_{{ $enquiry->id }}">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                </select>
                                <!-- Minute Dropdown -->
                                <select class="form-control me-2" name="minute_of_visit" style="max-width: 60px;" id="minute_of_visit_{{ $enquiry->id }}">
                                    @for ($i = 0; $i < 60; $i +=5)
                                        <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                </select>
                                <!-- AM/PM Dropdown -->
                                <select class="form-control" name="am_pm" style="max-width: 60px;" id="am_pm_{{ $enquiry->id }}">
                                    <option>AM</option>
                                    <option>PM</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="visit_remarks" class="form-label">Visit Remark</label>
                            <input class="form-control" type="text" name="visit_remarks" id="visit_remarks" required placeholder="Visit Remark">
                        </div>

                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="update_flow">Update Flow</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="update_flow" value="0">
                                    <label class="form-check-label">Visited</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="update_flow" value="1">
                                    <label class="form-check-label">Meeting Done</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="update_flow" value="2">
                                    <label class="form-check-label">Demo Given</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="contact_method_{{ $enquiry->id }}">Contact Method</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contact_method" value="0">
                                    <label class="form-check-label">Telephonic</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contact_method" value="1">
                                    <label class="form-check-label">In Person Meeting</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="contact_method_{{ $enquiry->id }}">Update Status</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="update_status" value="0">
                                    <label class="form-check-label">Running</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="update_status" value="1">
                                    <label class="form-check-label">Converted</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="update_status" value="3">
                                    <label class="form-check-label">Rejected</label>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="follow_up_date">Follow-Up Date <span class="login-danger">*</span></label>
                            <input class="form-control" type="text" id="follow_up_date" placeholder="DD-MM-YYYY" name="follow_up_date" oninput="formatDate(this)" maxlength="10">

                            <!-- Radio Button for 'Not Fixed' -->
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" name="follow_up_date" value="n/a" id="not_fixed">
                                <label class="form-check-label" for="not_fixed">Not Fixed</label>
                            </div>


                        </div>



                        @php
                        $pocs = \App\Models\Poc::where('enquiry_id', $enquiry->id)->get();

                        @endphp


                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="poc_{{ $enquiry->id }}">POC</label>
                            <div>
                                @foreach ($pocs as $poc)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="poc_ids[]" value="{{ $poc->id }}">
                                    <label class="form-check-label">{{ $poc->poc_name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach



@foreach ($enquiries as $enquiry)
<div id="add-poc-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullWidthModalLabel">Add POC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="px-3" action="{{ route('add.pocs', $enquiry->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-12 col-md-12 form-group local-forms">
                            <div class="poc-item">
                                <input type="text" name="poc_name" class="form-control mt-2" placeholder="POC Name" required>
                                <input type="text" name="poc_designation" class="form-control mt-2" placeholder="POC Designation" required>
                                <input type="text" name="poc_number" class="form-control mt-2" placeholder="POC Contact Number" maxlength="10" id="poc_number" required pattern="^\d{10}$" title="Please enter a 10-digit phone number" oninput="validateNumberInput(event)" />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">ADD POC</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach

@foreach ($enquiries as $enquiry)
<!-- Update Status Modal -->
<div id="update-status-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel{{ $enquiry->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="updateStatusModalLabel{{ $enquiry->id }}">Update Status</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <div class="form-group">
                        <label>Update Status</label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="update_status_{{ $enquiry->id }}" value="0" {{ $enquiry->status == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Running</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="update_status_{{ $enquiry->id }}" value="1" {{ $enquiry->status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Converted</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="update_status_{{ $enquiry->id }}" value="2" {{ $enquiry->status == 2 ? 'checked' : '' }}>
                                <label class="form-check-label">Rejected</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Update Status</button>
            </div>
        </div>
    </div>
</div>
@endforeach


@foreach ($enquiries as $enquiry)
<!-- Update Flow Modal -->
<div id="update-flow-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updateFlowModalLabel{{ $enquiry->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="updateFlowModalLabel{{ $enquiry->id }}">Update Flow</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <div class="form-group">
                        <label>Update Flow</label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="update_flow_{{ $enquiry->id }}" value="Visited">
                                <label class="form-check-label">Visited</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="update_flow_{{ $enquiry->id }}" value="Meeting Done">
                                <label class="form-check-label">Meeting Done</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="update_flow_{{ $enquiry->id }}" value="Demo Given">
                                <label class="form-check-label">Demo Given</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($enquiries as $enquiry)
<div id="view-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $enquiry->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="viewModalLabel{{ $enquiry->id }}">View Enquiry Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
                <div class="row">
                    <div class="col-12 col-md-6">
                        <p><strong>School Name:</strong> {{ $enquiry->school_name }}</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p><strong>City:</strong> {{ $enquiry->city }}</p>
                    </div>
                    <div id="additional-details{{ $enquiry->id }}" style="display: none;">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <p><strong>Board:</strong> {{ $enquiry->board }}</p>
                                <p><strong>Address:</strong> {{ $enquiry->address }}</p>
                                <p><strong>Pin code:</strong> {{ $enquiry->pincode }}</p>
                            </div>

                            <div class="col-12 col-md-6">
                                <p><strong>State:</strong> {{ $enquiry->state }}</p>
                                <p><strong>Website:</strong> <a href="{{ $enquiry->website }}" target="_blank" class="text-decoration-none">{{ $enquiry->website }}</a></p>
                                <p><strong>Last Visit Date:</strong> {{ $enquiry->created_at->format('Y-m-d') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-outline-primary btn-sm mx-auto d-block" onclick="toggleDetails({{ $enquiry->id }})" id="show-more-btn{{ $enquiry->id }}">View More</button>



                <!-- New Table Below -->
                <div class="mt-4">
                    <div class="table-responsive">
                    <table class="table table-striped table-primary table-bordered ">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Visit Date</th>
                                <th>Poc</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $visits = \App\Models\Visit::where('enquiry_id', $enquiry->id)->get();
                            @endphp
                            @if ($visits->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">No data found</td>
                            </tr>
                            @else
                            @foreach ($visits as $index => $visit)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $visit->date_of_visit }}</td>

                                <!-- Accessing poc_name using the relationship -->
                                <!-- <td>{{ $visit->poc->poc_name ?? 'No Name' }}</td> -->
                                <td>
            @php
                $pocNames = \App\Models\Poc::whereIn('id', $visit->poc_ids)->pluck('poc_name')->toArray();
            @endphp
            {{ implode(', ', $pocNames) ?: 'No Name' }}
        </td>

                                <td>{{ $visit->visit_remarks }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                </div>
            </div>



            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach


@foreach ($enquiries as $enquiry)
<div id="view-remark-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $enquiry->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="viewModalLabel{{ $enquiry->id }}">View Enquiry Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="">
                    <table class="table table-striped table-primary table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>S. No.</th>
                                <th>School Name</th>
                                <th>Expiry Date</th>
                                <th>Remark</th>
                                <th class="w-10">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>{{ $enquiry->school_name }}</td>
                                <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
                                <td>{{ $enquiry->remarks }}</td>
                                <td>
                                    <a href="#" class="dropdown-item btn btn-sm btn-primary " style="background-color: #4040ff;color:white;" data-bs-toggle="modal" data-bs-target="#add-remark-modal{{ $enquiry->id }}">
                                        Add Remark
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($enquiries as $enquiry)
<div id="update-follow-up-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $enquiry->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="viewModalLabel{{ $enquiry->id }}">Follow up date view</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <p><strong>Follow Up Date:</strong>
                    <input type="date">
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach


@foreach ($enquiries as $enquiry)
<div id="add-remark-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $enquiry->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="viewModalLabel{{ $enquiry->id }}">Add Remark</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update.remark', ['id' => $enquiry->id]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <label for="remark{{ $enquiry->id }}">Add Remark:</label><br>
                    <textarea id="remark{{ $enquiry->id }}" name="remarks" class="form-control" rows="5">{{ $enquiry->remarks }}</textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info" onclick="return confirm('Are you sure you want to submit?')">Submit</button>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach



@foreach ($enquiries as $enquiry)
<div id="edit-full-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $enquiry->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel{{ $enquiry->id }}">Edit Enquiry</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('enquiry.update', $enquiry->id) }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_name{{ $enquiry->id }}">School Name</label>
                                <input type="text" name="school_name" id="school_name{{ $enquiry->id }}" class="form-control" value="{{ old('school_name', $enquiry->school_name) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="board{{ $enquiry->id }}">Board</label>
                                <div class="d-flex gap-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="board" value="MP Board" {{ $enquiry->board == 'MP Board' ? 'checked' : '' }}>
                                        <label class="form-check-label">MP Board</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="board" value="Other" {{ $enquiry->board == 'Other' ? 'checked' : '' }}>
                                        <label class="form-check-label">Other</label>
                                    </div>
                                </div>
                                <input type="text" name="other_board_name" class="form-control mt-2" placeholder="Enter Board Name (if Other)" style="{{ $enquiry->board == 'Other' ? '' : 'display:none;' }}" value="{{ $enquiry->other_board_name }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address{{ $enquiry->id }}">Address</label>
                                <input type="text" name="address" id="address{{ $enquiry->id }}" class="form-control" value="{{ old('address', $enquiry->address) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pincode{{ $enquiry->id }}">Pincode</label>
                                <input type="text" name="pincode" id="pincode{{ $enquiry->id }}" value="{{ old('pincode', $enquiry->pincode) }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city{{ $enquiry->id }}">City</label>
                                <input type="text" name="city" id="city{{ $enquiry->id }}" value="{{ old('city', $enquiry->city) }}" class="form-control" required readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state{{ $enquiry->id }}">State</label>
                                <input type="text" name="state" id="state{{ $enquiry->id }}" value="{{ old('state', $enquiry->state) }}" class="form-control" required readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="website{{ $enquiry->id }}">Website</label>
                                <div class="d-flex gap-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="website" value="yes" {{ $enquiry->website == 'yes' ? 'checked' : '' }}>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="website" value="no" {{ $enquiry->website == 'no' ? 'checked' : '' }}>
                                        <label class="form-check-label">No</label>
                                    </div>
                                </div>
                                <input type="text" name="website_url" class="form-control mt-2" placeholder="Enter Website URL" style="{{ $enquiry->website == 'yes' ? '' : 'display:none;' }}" value="{{ $enquiry->website_url }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="students_count{{ $enquiry->id }}">Number of Students</label>
                                <input type="number" name="students_count" id="students_count{{ $enquiry->id }}" class="form-control" value="{{ old('students_count', $enquiry->students_count) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_software{{ $enquiry->id }}">Current Software</label>
                                <div class="d-flex gap-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="current_software" value="1" {{ $enquiry->current_software == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="current_software" value="0" {{ $enquiry->current_software == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">No</label>
                                    </div>
                                </div>
                                <input type="text" name="software_details" class="form-control mt-2" placeholder="Enter Software Details" style="{{ $enquiry->current_software == 'yes' ? '' : 'display:none;' }}" value="{{ $enquiry->software_details }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="remarks{{ $enquiry->id }}">Remarks</label>
                                <textarea name="remarks" id="remarks{{ $enquiry->id }}" class="form-control">{{ old('remarks', $enquiry->remarks) }}</textarea>
                            </div>
                        </div>

                        <!-- <div class="col-md-12">
                            <div class="form-group">
                                <label for="poc{{ $enquiry->id }}">Add POC</label>
                                <button type="button" class="btn btn-outline-primary" id="add_poc_{{ $enquiry->id }}">Add POC</button>

                                <div id="poc_details_container{{ $enquiry->id }}">
                                    @if (is_array($enquiry->poc_details) && count($enquiry->poc_details) > 0)
                                    @foreach ($enquiry->poc_details as $poc)
                                    <div class="poc-item">
                                        <input type="text" name="poc_name[]" class="form-control mt-2" placeholder="POC Name" value="{{ $poc['poc_name'] }}">
                                        <input type="text" name="poc_designation[]" class="form-control mt-2" placeholder="POC Designation" value="{{ $poc['poc_designation'] }}">
                                        <input type="text" name="poc_contact[]" class="form-control mt-2" placeholder="POC Contact Number" value="{{ $poc['poc_contact'] }}">
                                        <button type="button" class="btn btn-danger remove_poc">Remove</button>
                                    </div>
                                    @endforeach
                                    @else
                                   <div class="poc-item">
                                        <input type="text" name="poc_name[]" class="form-control mt-2" placeholder="POC Name">
                                        <input type="text" name="poc_designation[]" class="form-control mt-2" placeholder="POC Designation">
                                        <input type="text" name="poc_contact[]" class="form-control mt-2" placeholder="POC Contact Number">
                                        <button type="button" class="btn btn-danger remove_poc">Remove</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div> -->

                        <input type="hidden" name="poc_details" id="poc_details{{ $enquiry->id }}">


                        <div class="col-md-12 text-end modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endforeach

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Add a new POC form set when the "Add POC" button is clicked
        $('[id^="add_poc_"]').on('click', function() {
            const modalId = $(this).attr('id').split('_')[2]; // Get the enquiry ID from the button ID
            const pocItemHtml = `
                <div class="poc-item">
                    <input type="text" name="poc_name[]" class="form-control mt-2" placeholder="POC Name">
                    <input type="text" name="poc_designation[]" class="form-control mt-2" placeholder="POC Designation">
                    <input type="text" name="poc_contact[]" class="form-control mt-2" placeholder="POC Contact Number">
                    <button type="button" class="btn btn-danger remove_poc">Remove</button>
                </div>
            `;
            $(`#poc_details_container${modalId}`).append(pocItemHtml); // Append the new POC input fields
        });

        // Remove a POC item when "Remove" button is clicked
        $(document).on('click', '.remove_poc', function() {
            $(this).closest('.poc-item').remove(); // Remove the corresponding POC fields
        });

        // Collect POC data before form submission
        $('form').on('submit', function(e) {
            const modalId = $(this).attr('action').split('/').pop(); // Get the enquiry ID from the action URL
            let pocDetails = [];

            // Loop through each POC item and collect the data
            $(`#poc_details_container${modalId} .poc-item`).each(function() {
                const pocName = $(this).find('input[name="poc_name[]"]').val();
                const pocDesignation = $(this).find('input[name="poc_designation[]"]').val();
                const pocContact = $(this).find('input[name="poc_contact[]"]').val();

                // Add the POC details to the array if they are filled
                if (pocName && pocDesignation && pocContact) {
                    pocDetails.push({
                        poc_name: pocName,
                        poc_designation: pocDesignation,
                        poc_contact: pocContact
                    });
                }
            });

            $(`#poc_details${modalId}`).val(JSON.stringify(pocDetails));

            return true;
        });
    });
</script>




@include('user.enquiry.js_editfile')