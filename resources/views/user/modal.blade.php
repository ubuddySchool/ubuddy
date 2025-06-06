@foreach ($enquiries as $enquiry)
    <div id="full-width-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="fullWidthModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fullWidthModalLabel">Add Visit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('add.visit', $enquiry->id) }}" method="POST" enctype="multipart">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6 form-group local-forms">
                                <label for="contact_method_{{ $enquiry->id }}">Visit Type<span
                                        class="login-danger">*</span></label>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="contact_method"
                                            value="0" required>
                                        <label class="form-check-label">Telephonic</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="contact_method"
                                            value="1">
                                        <label class="form-check-label">In Person Meeting</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Date of Visit -->
                            <!-- <div class="col-12 col-md-6 form-group local-forms">
                            <label for="visit_date_{{ $enquiry->id }}">Date Of Visit <span class="login-danger">*</span></label>
                            <input class="form-control" name="date_of_visit" type="text" id="visit_date_{{ $enquiry->id }}" placeholder="DD-MM-YYYY" oninput="formatDate(this)" maxlength="10" required>
                        </div> -->

                            <!-- Time of Visit -->
                            <div class="col-12 col-md-6 form-group local-forms">
                                <label for="time_of_visit_{{ $enquiry->id }}">Visit Time <span
                                        class="login-danger">*</span></label>
                                <div class="d-flex">
                                    <!-- Hour Dropdown -->
                                    <select class="form-control me-2" name="hour_of_visit" style="max-width: 60px;"
                                        id="hour_of_visit_{{ $enquiry->id }}" required>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                    <!-- Minute Dropdown -->
                                    <select class="form-control me-2" name="minute_of_visit" style="max-width: 60px;"
                                        id="minute_of_visit_{{ $enquiry->id }}" required>
                                        @for ($i = 0; $i < 60; $i += 5)
                                            <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                    <!-- AM/PM Dropdown -->
                                    <select class="form-control" name="am_pm" style="max-width: 60px;"
                                        id="am_pm_{{ $enquiry->id }}" required>
                                        <option>AM</option>
                                        <option>PM</option>
                                    </select>
                                </div>
                            </div>

                            @php
                                $pocs = \App\Models\Poc::where('enquiry_id', $enquiry->id)->get();
                            @endphp

                            <div class="col-12 col-md-6 form-group local-forms">
                                <label for="poc_{{ $enquiry->id }}">POC<span class="login-danger">*</span></label>
                                <div>
                                    @foreach ($pocs as $poc)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="poc_ids[]"
                                                value="{{ $poc->id }}">
                                            <label class="form-check-label">{{ $poc->poc_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12 col-md-6 form-group local-forms">
                                <label for="update_status_{{ $enquiry->id }}">Update Status<span
                                        class="login-danger">*</span></label>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="update_status"
                                            value="0" required>
                                        <label class="form-check-label">Running</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="update_status"
                                            value="1">
                                        <label class="form-check-label">Converted</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="update_status"
                                            value="2">
                                        <label class="form-check-label">Rejected</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 form-group local-forms">
                                <label for="visit_remarks" class="form-label">Remarks</label>
                                <input class="form-control" type="text" name="visit_remarks"
                                    id="visit_remarks_{{ $enquiry->id }}" required placeholder="Visit Remark">
                            </div>
                            <div class="col-12 col-md-6 form-group local-forms">
                                <label for="follow_up_date_{{ $enquiry->id }}">Follow-Up Date <span
                                        class="login-danger">*</span></label>
                                <input class="form-control" type="text" id="follow_up_date_{{ $enquiry->id }}"
                                    placeholder="DD-MM-YYYY" name="follow_up_date" oninput="formatDate(this)"
                                    maxlength="10">

                                <!-- Radio Button for 'Not Fixed' -->
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="follow_up_date"
                                        value="n/a" id="not_fixed_{{ $enquiry->id }}"
                                        onchange="toggleFollowUpDate({{ $enquiry->id }})">
                                    <label class="form-check-label" for="not_fixed_{{ $enquiry->id }}">Not
                                        Fixed</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>Add images (Max 3)</label>
                                <div class="border p-4 text-center bg-light rounded">

                                    <p id="uploadPrompt_1">Choose how to add images</p>

                                    <!-- Upload & Camera Buttons -->
                                    <div class="mb-3 d-flex justify-content-center gap-3">
                                        <button type="button" id="cameraBtn_1" class="btn btn-outline-success">📷
                                            Use Camera</button>
                                        <button type="button" id="galleryBtn_1" class="btn btn-outline-primary">📁
                                            Upload from Device</button>
                                    </div>

                                    <!-- Hidden Inputs -->
                                    <input type="file" id="cameraInput_1" accept="image/*" capture="environment"
                                        style="display:none">
                                    <input type="file" id="galleryInput_1" accept="image/*" multiple
                                        style="display:none">

                                    <!-- Webcam (desktop) -->
                                    <div id="cameraContainer" class="mb-3" style="display: none;">
                                        <video id="video" width="320" height="240" autoplay></video><br>
                                        <button type="button" class="btn btn-sm btn-primary my-2"
                                            onclick="takePhoto()">📸 Capture Photo</button>
                                    </div>

                                    <!-- Previews -->
                                    <div id="gallery_1" class="mt-3 d-flex flex-wrap gap-2 justify-content-center">
                                    </div>
                                </div>
                            </div>





                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary " disabled>Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    function toggleFollowUpDate(enquiryId) {
        const inputField = document.getElementById("follow_up_date_" + enquiryId);
        const checkbox = document.getElementById("not_fixed_" + enquiryId);
        inputField.disabled = checkbox.checked;
    }
</script>



@foreach ($enquiries as $enquiry)
    <div id="add-poc-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="fullWidthModalLabel" aria-hidden="true">
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
                                    <input type="text" name="poc_name" class="form-control mt-2"
                                        placeholder="POC Name" required>
                                    <input type="text" name="poc_designation" class="form-control mt-2"
                                        placeholder="POC Designation" required>
                                    <input type="text" name="poc_number" class="form-control mt-2"
                                        placeholder="POC Contact Number" maxlength="10" id="poc_number" required
                                        pattern="^\d{10}$" title="Please enter a 10-digit phone number"
                                        oninput="validateNumberInput(event)" />
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">ADD POC</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@foreach ($enquiries as $enquiry)
    <!-- Update Status Modal -->
    <div id="update-status-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="updateStatusModalLabel{{ $enquiry->id }}" aria-hidden="true">
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
                                    <input class="form-check-input" type="radio"
                                        name="update_status_{{ $enquiry->id }}" value="0"
                                        {{ $enquiry->status == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">Running</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="update_status_{{ $enquiry->id }}" value="1"
                                        {{ $enquiry->status == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Converted</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="update_status_{{ $enquiry->id }}" value="2"
                                        {{ $enquiry->status == 2 ? 'checked' : '' }}>
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
    <div id="view-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="viewModalLabel{{ $enquiry->id }}" aria-hidden="true">
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
                            <p><strong>Board:</strong>
                                @if ($enquiry->board == 'MP Board')
                                    {{ $enquiry->board }}
                                @else
                                    {{ $enquiry->other_board_name }}
                                @endif
                            </p>

                        </div>

                        <div id="additional-details{{ $enquiry->id }}" style="display: none;">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <p><strong>Website:</strong>
                                        @if ($enquiry->website == 'yes')
                                            <a href="{{ $enquiry->website_url }}" target="_blank"
                                                class="text-decoration-none">{{ $enquiry->website_url }}</a>
                                        @elseif($enquiry->website == 'not_know')
                                            <span class="badge bg-danger">Not know</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif

                                    </p>
                                    <p><strong>Software :</strong>
                                        @if ($enquiry->current_software == 1)
                                            {{ $enquiry->software_details }}
                                        @elseif($enquiry->current_software == 0)
                                            <span class="badge bg-danger">No</span>
                                        @elseif($enquiry->current_software == 2)
                                            <span class="badge bg-danger">Not know</span>
                                        @endif
                                    </p>
                                    <p><strong>Student No.:</strong> {{ $enquiry->students_count }}</p>
                                    <p><strong>Enquiry create Date:</strong>
                                        {{ $enquiry->created_at->format('d-m-y') }}</p>
                                    <p><strong>Enquiry Remarks:</strong> {{ $enquiry->remarks }}</p>

                                    @php
                                        $images = json_decode($enquiry->images ?? '[]');
                                    @endphp
                                    @if (!empty($images))
                                        <p><strong>Images:</strong>
                                            @foreach ($images as $index => $imagePath)
                                                <div class="position-relative" style="display:inline-block;">
                                                    <a href="{{ asset($imagePath) }}" class="glightbox"
                                                        data-gallery="enquiry-gallery">
                                                        <img src="{{ asset($imagePath) }}" class="rounded"
                                                            style="width: 100px; height: 100px; object-fit: cover;">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </p>
                                    @endif
                                </div>

                                <div class="col-12 col-md-6">
                                    <p><strong>Address:</strong> {{ $enquiry->address }}</p>
                                    <p><strong>Town:</strong> {{ $enquiry->town }}</p>
                                    <p><strong>City:</strong> {{ $enquiry->city }}</p>
                                    <p><strong>State:</strong> {{ $enquiry->state }}</p>
                                    <p><strong>Pin code:</strong> {{ $enquiry->pincode }}</p>
                                    <p><strong>Interested in software:</strong>
                                        @if ($enquiry->interest_software == 1)
                                            <span class="badge bg-primary">Interested</span>
                                        @elseif($enquiry->interest_software == 0)
                                            <span class="badge bg-secondary">Not Interested</span>
                                        @elseif($enquiry->interest_software == 2)
                                            <span class="badge bg-success">Highly Interested</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <button class="btn btn-outline-primary btn-sm mx-auto d-block"
                        onclick="toggleDetails({{ $enquiry->id }})" id="show-more-btn{{ $enquiry->id }}">View
                        More</button>

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
                                        <th>Contact Method</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $visits = \App\Models\Visit::where('enquiry_id', $enquiry->id)->get();
                                    @endphp
                                    @if ($visits->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">No data found</td>
                                        </tr>
                                    @else
                                        @foreach ($visits as $index => $visit)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($visit->date_of_visit)->format('d-m-Y') }}
                                                </td>

                                                <!-- Accessing poc_name using the relationship -->
                                                <!-- <td>{{ $visit->poc->poc_name ?? 'N/A' }}</td> -->
                                                <td>
                                                    @php
                                                        $pocNames = \App\Models\Poc::whereIn('id', $visit->poc_ids)
                                                            ->pluck('poc_name')
                                                            ->toArray();
                                                    @endphp
                                                    {{ implode(', ', $pocNames) ?: 'N/A' }}
                                                </td>

                                                <td>{{ $visit->visit_remarks }}</td>
                                                <td>
                                                    @if ($visit->contact_method == 0)
                                                        Telephonic
                                                    @elseif ($visit->contact_method == 1)
                                                        In-Person Meeting
                                                    @endif
                                                </td>
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
    <div id="view-remark-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="viewModalLabel{{ $enquiry->id }}" aria-hidden="true">
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
                                        <a href="#" class="dropdown-item btn btn-sm btn-primary "
                                            style="background-color: #4040ff;color:white;" data-bs-toggle="modal"
                                            data-bs-target="#add-remark-modal{{ $enquiry->id }}">
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
    <div id="update-follow-up-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="viewModalLabel{{ $enquiry->id }}" aria-hidden="true">
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
    <div id="add-remark-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="viewModalLabel{{ $enquiry->id }}" aria-hidden="true">
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
                        <textarea id="remark{{ $enquiry->id }}" name="remarks" class="form-control" rows="5">{{ $enquiry->expired_remarks }}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info"
                        onclick="return confirm('Are you sure you want to submit?')">Submit</button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@if (isset($visit))
    <div id="add-remark-modal{{ $visit->id }}" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="viewModalLabel{{ $visit->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewModalLabel{{ $visit->id }}">Add Remark</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.remark', ['id' => $visit->id]) }}" method="POST">
                        @csrf
                        <label for="remark{{ $visit->id }}">Add Remark:</label><br>
                        <textarea id="remark{{ $visit->id }}" name="remarks" class="form-control" rows="5">{{ $visit->expired_remarks }}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info"
                        onclick="return confirm('Are you sure you want to submit?')">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endif
@foreach ($enquiries as $enquiry)
    <div id="edit-full-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel{{ $enquiry->id }}" aria-hidden="true">
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
                            <!-- School Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="school_name{{ $enquiry->id }}">School Name</label>
                                    <input type="text" name="school_name" id="school_name{{ $enquiry->id }}"
                                        class="form-control" value="{{ old('school_name', $enquiry->school_name) }}"
                                        required>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address{{ $enquiry->id }}">Address</label>
                                    <input type="text" name="address" id="address{{ $enquiry->id }}"
                                        class="form-control" value="{{ old('address', $enquiry->address) }}"
                                        required>
                                </div>
                            </div>

                            <!-- Pincode -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pincode{{ $enquiry->id }}">Pincode</label>
                                    <input type="text" name="pincode" id="pincode{{ $enquiry->id }}"
                                        value="{{ old('pincode', $enquiry->pincode) }}" class="form-control"
                                        required>
                                </div>
                            </div>

                            <!-- Town -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="town">Town</label>
                                    <input type="text" name="town" id="town{{ $enquiry->id }}"
                                        value="{{ old('town', $enquiry->town) }}" class="form-control select2">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city{{ $enquiry->id }}">City</label>
                                    <input type="text" name="city" id="city{{ $enquiry->id }}"
                                        value="{{ old('city', $enquiry->city) }}" class="form-control" required
                                        readonly>
                                </div>
                            </div>

                            <!-- State -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state{{ $enquiry->id }}">State</label>
                                    <input type="text" name="state" id="state{{ $enquiry->id }}"
                                        value="{{ old('state', $enquiry->state) }}" class="form-control" required
                                        readonly>
                                </div>
                            </div>

                            <!-- Current Software -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="current_software{{ $enquiry->id }}">Current Software</label>
                                    <div class="d-flex gap-5">
                                        <div class="form-check">
                                            <input class="form-check-input" id="software_yes{{ $enquiry->id }}"
                                                type="radio" name="current_software" value="1"
                                                {{ $enquiry->current_software == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="software_no{{ $enquiry->id }}"
                                                type="radio" name="current_software" value="0"
                                                {{ $enquiry->current_software == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label">No</label>
                                        </div>
                                    </div>
                                    <input type="text" name="software_details"
                                        id="software_details{{ $enquiry->id }}" class="form-control mt-2"
                                        placeholder="Enter Software Details"
                                        style="{{ $enquiry->current_software == '1' ? '' : 'display:none;' }}"
                                        value="{{ $enquiry->software_details }}">
                                </div>
                            </div>

                            <!-- Website -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="website{{ $enquiry->id }}">Website</label>
                                    <div class="d-flex gap-5">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                id="website_yes{{ $enquiry->id }}" name="website" value="yes"
                                                {{ $enquiry->website == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                id="website_no{{ $enquiry->id }}" name="website" value="no"
                                                {{ $enquiry->website == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label">No</label>
                                        </div>
                                    </div>
                                    <input type="text" id="website_url{{ $enquiry->id }}" name="website_url"
                                        class="form-control mt-2" placeholder="Enter Website URL"
                                        style="{{ $enquiry->website == 'yes' ? '' : 'display:none;' }}"
                                        value="{{ $enquiry->website_url }}">
                                </div>
                            </div>

                            <!-- Board -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="board{{ $enquiry->id }}">Board</label>
                                    <div class="d-flex gap-5">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                id="mp_board{{ $enquiry->id }}" name="board" value="MP Board"
                                                {{ $enquiry->board == 'MP Board' ? 'checked' : '' }}>
                                            <label class="form-check-label">MP Board</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                id="other_board{{ $enquiry->id }}" name="board" value="Other"
                                                {{ $enquiry->board == 'Other' ? 'checked' : '' }}>
                                            <label class="form-check-label">Other</label>
                                        </div>
                                    </div>
                                    <input type="text" name="other_board_name"
                                        id="other_board_name{{ $enquiry->id }}" class="form-control mt-2"
                                        placeholder="Enter Board Name (if Other)"
                                        style="{{ $enquiry->board == 'Other' ? '' : 'display:none;' }}"
                                        value="{{ $enquiry->other_board_name }}">
                                </div>
                            </div>

                            <!-- Remarks -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="remarks{{ $enquiry->id }}">Remarks</label>
                                    <textarea name="remarks" id="remarks{{ $enquiry->id }}" class="form-control">{{ old('remarks', $enquiry->remarks) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>Add images (Max 3)</label>
                                <div class="border p-4 text-center bg-light rounded">

                                    <p id="uploadPrompt_1">Choose how to add images</p>

                                    <!-- Upload & Camera Buttons -->
                                    <div class="mb-3 d-flex justify-content-center gap-3">
                                        <button type="button" id="cameraBtn_1" class="btn btn-outline-success">📷
                                            Use Camera</button>
                                        <button type="button" id="galleryBtn_1" class="btn btn-outline-primary">📁
                                            Upload from Device</button>
                                    </div>

                                    <!-- Hidden Inputs -->
                                    <input type="file" id="cameraInput_1" accept="image/*" capture="environment"
                                        style="display:none">
                                    <input type="file" id="galleryInput_1" accept="image/*" multiple
                                        style="display:none">

                                    <!-- Webcam (desktop) -->
                                    <div id="cameraContainer" class="mb-3" style="display: none;">
                                        <video id="video" width="320" height="240" autoplay></video><br>
                                        <button type="button" class="btn btn-sm btn-primary my-2"
                                            onclick="takePhoto()">📸 Capture Photo</button>
                                    </div>

                                    <!-- Previews -->
                                    <div id="gallery_1" class="mt-3 d-flex flex-wrap gap-2 justify-content-center">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-end modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Iterate over all enquiries to attach event listeners dynamically
        @foreach ($enquiries as $enquiry)
            (function(enquiryId) {
                // Handle software input toggle
                const softwareYes = document.getElementById('software_yes' + enquiryId);
                const softwareNo = document.getElementById('software_no' + enquiryId);
                const softwareDetails = document.getElementById('software_details' + enquiryId);

                if (softwareYes && softwareNo && softwareDetails) {
                    softwareYes.addEventListener('change', function() {
                        softwareDetails.style.display = 'block';
                    });
                    softwareNo.addEventListener('change', function() {
                        softwareDetails.style.display = 'none';
                    });
                }

                // Handle website URL input toggle
                const websiteYes = document.getElementById('website_yes' + enquiryId);
                const websiteNo = document.getElementById('website_no' + enquiryId);
                const websiteUrl = document.getElementById('website_url' + enquiryId);

                if (websiteYes && websiteNo && websiteUrl) {
                    websiteYes.addEventListener('change', function() {
                        websiteUrl.style.display = 'block';
                    });
                    websiteNo.addEventListener('change', function() {
                        websiteUrl.style.display = 'none';
                    });
                }

                // Handle board input toggle
                const mpBoard = document.getElementById('mp_board' + enquiryId);
                const otherBoard = document.getElementById('other_board' + enquiryId);
                const otherBoardName = document.getElementById('other_board_name' + enquiryId);

                if (mpBoard && otherBoard && otherBoardName) {
                    mpBoard.addEventListener('change', function() {
                        otherBoardName.style.display = 'none';
                    });
                    otherBoard.addEventListener('change', function() {
                        otherBoardName.style.display = 'block';
                    });
                }
            })({
                {
                    $enquiry - > id
                }
            });
        @endforeach
    });
</script>



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
            $(`#poc_details_container${modalId}`).append(
            pocItemHtml); // Append the new POC input fields
        });

        // Remove a POC item when "Remove" button is clicked
        $(document).on('click', '.remove_poc', function() {
            $(this).closest('.poc-item').remove(); // Remove the corresponding POC fields
        });

        // Collect POC data before form submission
        $('form').on('submit', function(e) {
            const modalId = $(this).attr('action').split('/')
        .pop(); // Get the enquiry ID from the action URL
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
<!--
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const MAX_FILES = 3;

        const gallery_1 = document.getElementById('gallery_1');
        const uploadPrompt_1 = document.getElementById('uploadPrompt_1');

        const cameraInput_1 = document.getElementById('cameraInput_1');
        const galleryInput_1 = document.getElementById('galleryInput_1');

        const cameraBtn_1 = document.getElementById('cameraBtn_1');
        const galleryBtn_1 = document.getElementById('galleryBtn_1');

        const cameraContainer = document.getElementById('cameraContainer');
        const video = document.getElementById('video');

        let stream;
        let filesArray = [];

        // Buttons
        cameraBtn_1.addEventListener('click', () => {
            if (isMobile()) {
                cameraInput_1.click(); // Use mobile's native camera
            } else {
                startWebcam(); // Use WebRTC on desktop
            }
        });

        galleryBtn_1.addEventListener('click', () => galleryInput_1.click());

        // Inputs
        cameraInput_1.addEventListener('change', () => handleFiles([...cameraInput_1.files]));
        galleryInput_1.addEventListener('change', () => handleFiles([...galleryInput_1.files]));

        function isMobile() {
            return /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        }

        function startWebcam() {
            cameraContainer.style.display = 'block';
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(s => {
                    stream = s;
                    video.srcObject = stream;
                })
                .catch(err => {
                    alert("Camera not accessible.");
                    console.error(err);
                });
        }

        // Capture image from webcam
        window.takePhoto = function() {
            const canvas = document.createElement('canvas');
            canvas.width = 320;
            canvas.height = 240;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataUrl = canvas.toDataURL('image/jpeg');

            fetch(dataUrl)
                .then(res => res.blob())
                .then(blob => {
                    if (filesArray.length >= MAX_FILES) {
                        alert(`Max ${MAX_FILES} images allowed.`);
                        return;
                    }
                    const file = new File([blob], `captured_${Date.now()}.jpg`, {
                        type: 'image/jpeg'
                    });
                    filesArray.push(file);
                    updateGallery_1();
                });

            // Stop camera
            stream.getTracks().forEach(track => track.stop());
            cameraContainer.style.display = 'none';
        }

        function handleFiles(newFiles) {
            if (filesArray.length + newFiles.length > MAX_FILES) {
                alert(`You can only upload a maximum of ${MAX_FILES} images.`);
                return;
            }

            newFiles.forEach(file => {
                if (filesArray.length < MAX_FILES) {
                    filesArray.push(file);
                }
            });

            updateGallery_1();
        }

        function updateGallery_1() {
            gallery_1.innerHTML = '';
            uploadPrompt_1.style.display = filesArray.length ? 'none' : 'block';

            const dataTransfer_1 = new DataTransfer();

            filesArray.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('position-relative');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.width = '100px';

                    const removeBtn = document.createElement('button');
                    removeBtn.textContent = '×';
                    removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
                    removeBtn.onclick = function() {
                        filesArray.splice(index, 1);
                        updateGallery_1();
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    gallery_1.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
                dataTransfer_1.items.add(file);
            });

            // Set files to both inputs to support form submission
            galleryInput_1.files = dataTransfer_1.files;
            cameraInput_1.files = dataTransfer_1.files;
        }
    });
</script> -->


@include('user.enquiry.js_file')

@include('user.enquiry.js_editfile')
