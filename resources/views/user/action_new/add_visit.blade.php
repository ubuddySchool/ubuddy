@extends('layouts.apphome')

@section('content')
<div class="content container-fluid">

    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Add Visit</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                <form action="#" method="POST" enctype="multipart">
                @csrf
                        <div class="row">

                            <!-- Visit Type -->
                            <div class="col-md-4 form-group local-forms">
                                <label>Visit Type<span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contact_method" value="0" checked>
                                    <label class="form-check-label">Telephonic</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contact_method" value="1">
                                    <label class="form-check-label">In Person Meeting</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-4 form-group local-forms">
                            <label for="time_of_visit_">Visit Time <span class="login-danger">*</span></label>
                            <div class="d-flex">
                                <!-- Hour Dropdown -->
                                <select class="form-control me-2" name="hour_of_visit" style="max-width: 60px;" id="hour_of_visit_" required>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                </select>
                                <!-- Minute Dropdown -->
                                <select class="form-control me-2" name="minute_of_visit" style="max-width: 60px;" id="minute_of_visit_" required>
                                    @for ($i = 0; $i < 60; $i +=5)
                                        <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                </select>
                                <!-- AM/PM Dropdown -->
                                <select class="form-control" name="am_pm" style="max-width: 60px;" id="am_pm_" required>
                                    <option>AM</option>
                                    <option>PM</option>
                                </select>
                            </div>
                        </div>

                            <!-- POC Dropdown -->
                            <div class="col-12 col-md-4 form-group local-forms">
                            <label for="poc_">POC<span class="login-danger">*</span></label>
                            <div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="poc_ids[]" value="">
                                    <label class="form-check-label">Ram singh</label>
                                </div>
                             
                            </div>
                        </div>

                            <!-- Visit Status -->
                            <div class="col-12 col-md-4 form-group local-forms">
                            <label for="update_status_">Update Status<span class="login-danger">*</span></label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="update_status" value="0" required>
                                    <label class="form-check-label">Running</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="update_status" value="1">
                                    <label class="form-check-label">Converted</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="update_status" value="2">
                                    <label class="form-check-label">Rejected</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 form-group local-forms">
                            <!-- <label for="visit_remarks" class="form-label">Remarks</label> -->
                            <input class="form-control" type="text" name="visit_remarks" id="visit_remarks_" required placeholder="Enter Remark">
                        </div>
                        <div class="col-12 col-md-4 form-group local-forms">
                            <label for="follow_up_date_">Follow-Up Date <span class="login-danger">*</span></label>
                            <input class="form-control" type="text" id="follow_up_date_" placeholder="DD-MM-YYYY" name="follow_up_date" oninput="formatDate(this)" maxlength="10">

                            <!-- Radio Button for 'Not Fixed' -->
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="follow_up_date" value="n/a" id="not_fixed_" onchange="toggleFollowUpDate()">
                                <label class="form-check-label" for="not_fixed_">Not Fixed</label>
                            </div>
                        </div>



                            <div class="col-md-12">
                                <label>Upload Images (Max 3)</label>
                                <div class="border p-4 text-center bg-light rounded">

                                    <p id="uploadPrompt">Choose how to add images</p>

                                    <!-- Upload & Camera Buttons -->
                                    <div class="mb-3 d-flex justify-content-center gap-3">
                                        <button type="button" id="cameraBtn" class="btn btn-outline-success">📷 Use Camera</button>
                                        <button type="button" id="galleryBtn" class="btn btn-outline-primary">📁 Upload from Device</button>
                                    </div>

                                    <!-- Hidden Inputs -->
                                    <input type="file" id="cameraInput" accept="image/*" capture="environment" style="display:none">
                                    <input type="file" id="galleryInput" accept="image/*" multiple style="display:none">

                                    <!-- Webcam (desktop) -->
                                    <div id="cameraContainer" class="mb-3" style="display: none;">
                                        <video id="video" width="320" height="240" autoplay></video><br>
                                        <button type="button" class="btn btn-sm btn-primary my-2" onclick="takePhoto()">📸 Capture Photo</button>
                                    </div>

                                    <!-- Previews -->
                                    <div id="gallery" class="mt-3 d-flex flex-wrap gap-2 justify-content-center"></div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-success">Submit Visit</button>
                                <a href="#" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection