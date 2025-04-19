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
                            <div class="col-md-3 form-group local-forms">
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

                            <div class="col-12 col-md-3 form-group local-forms">
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
                            <div class="col-12 col-md-3 form-group local-forms">
                            <label for="poc_">POC<span class="login-danger">*</span></label>
                            <div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="poc_ids[]" value="">
                                    <label class="form-check-label">Ram singh</label>
                                </div>
                             
                            </div>
                        </div>

                            <!-- Visit Status -->
                            <div class="col-12 col-md-3 form-group local-forms">
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

                        <div class="col-12 col-md-3 form-group local-forms">
                            <!-- <label for="visit_remarks" class="form-label">Remarks</label> -->
                            <input class="form-control" type="text" name="visit_remarks" id="visit_remarks_" required placeholder="Enter Remark">
                        </div>
                        <div class="col-12 col-md-3 form-group local-forms">
                            <label for="follow_up_date_">Follow-Up Date <span class="login-danger">*</span></label>
                            <input class="form-control" type="text" id="follow_up_date_" placeholder="DD-MM-YYYY" name="follow_up_date" oninput="formatDate(this)" maxlength="10">

                            <!-- Radio Button for 'Not Fixed' -->
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="follow_up_date" value="n/a" id="not_fixed_" onchange="toggleFollowUpDate()">
                                <label class="form-check-label" for="not_fixed_">Not Fixed</label>
                            </div>
                        </div>



                           

                            <input type="text" id="locationInput" placeholder="Your location will appear here">


                            <!-- Submit Buttons -->
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-success">Submit Visit</button>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection