@extends('layouts.apphome')

@section('content')
<div class="content container-fluid">
    <!-- <div id="client-validation-errors"></div> -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col align-items-center">
                                <a href="{{ route('home') }}" class="text-decoration-none text-dark me-2 backButton">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <h3 class="page-title">Add Visit</h3>
                            </div>
                        </div>
                    </div>
                    <form id="visitForm" action="{{ route('visit.store', $enquiry->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Visit Type -->
                            <div class="col-md-3 form-group local-forms">
                                <label>Visit Type<span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" id="contact_method_0" type="radio" name="contact_method" value="0">
                                    <label class="form-check-label" for="contact_method_0">Telephonic</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="contact_method_1" type="radio" name="contact_method" value="1">
                                    <label class="form-check-label" for="contact_method_1">In Person Meeting</label>
                                </div>
                                <div class="text-danger validation-message" data-field="contact_method"></div>
                            </div>

                            <!-- Visit Time -->
                            <div class="col-12 col-md-3 form-group local-forms">
                                <label>Visit Time <span class="login-danger">*</span></label>
                                <div class="d-flex">
                                    <select class="form-control me-2" name="hour_of_visit" style="max-width: 60px;">

                                        @for ($i = 1; $i <= 12; $i++)
                                            <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                            @endfor
                                    </select>
                                    <select class="form-control me-2" name="minute_of_visit" style="max-width: 60px;">
                                        @for ($i = 0; $i < 60; $i +=5)
                                            <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                            @endfor
                                    </select>
                                    <select class="form-control" name="am_pm" style="max-width: 60px;">
                                        <option>AM</option>
                                        <option>PM</option>
                                    </select>
                                </div>
                                <div class="text-danger validation-message" data-field="visit_time"></div>
                            </div>

                            <!-- POC -->
                            @php
                            $pocs = \App\Models\Poc::where('enquiry_id', $enquiry->id)->get();
                            @endphp
                            <div class="col-12 col-md-3 form-group local-forms">
                                <label>POC <span class="login-danger">*</span></label>
                                @foreach ($pocs as $poc)
                                <div class="form-check">
                                    <input class="form-check-input" id="poc_ids_{{ $poc->id }}" type="checkbox" name="poc_ids[]" value="{{ $poc->id }}">
                                    <label class="form-check-label" for="poc_ids_{{ $poc->id }}">{{ $poc->poc_name }}</label>
                                </div>
                                @endforeach
                                <div class="text-danger validation-message" data-field="poc_ids"></div>
                            </div>

                            @php
                            $latestVisit = \App\Models\Visit::where('enquiry_id', $enquiry->id)
                            ->orderByDesc('created_at')
                            ->first();

                            $selectedStatus = $latestVisit->update_status ?? null;

                            $disableAll = in_array($selectedStatus, [1, 2, 3, 4]);

                            $showConvertedRejected = in_array($selectedStatus, [1, 2]);
                            $showRConvertedRRejected = in_array($selectedStatus, [3, 4]);
                            $isRunningOrNull = $selectedStatus === 0 || is_null($selectedStatus);
                            @endphp

                            <!-- Visit Status -->
                            <div class="col-12 col-md-3 form-group local-forms">
                                <label>Update Status<span class="login-danger">*</span></label>

                                {{-- Show Running only if NOT Converted/Rejected --}}
                                @if(!$showConvertedRejected)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="update_status" id="update_status_0" value="0"
                                        {{ $selectedStatus === 0 ? 'checked' : '' }}
                                        {{ $disableAll ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="update_status_0">Running</label>
                                </div>
                                @endif

                                {{-- Show Converted and Rejected ONLY if update_status is 1 or 2 --}}
                                @if($showConvertedRejected)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="update_status" value="1"
                                        {{ $selectedStatus === 1 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label">Converted</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="update_status" value="2"
                                        {{ $selectedStatus === 2 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label">Rejected</label>
                                </div>
                                @endif

                                {{-- Show R-Converted and R-Rejected only if NOT Converted/Rejected --}}
                                @if(!$showConvertedRejected)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="update_status_3" name="update_status" value="3"
                                        {{ $selectedStatus === 3 ? 'checked' : '' }}
                                        {{ $disableAll ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="update_status_3">R-Converted</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="update_status_4" name="update_status" value="4"
                                        {{ $selectedStatus === 4 ? 'checked' : '' }}
                                        {{ $disableAll ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="update_status_4">R-Rejected</label>
                                </div>
                                @endif

                                <div class="text-danger validation-message" data-field="update_status"></div>
                            </div>


                            <!-- Remarks -->
                            <div class="col-12 col-md-3 form-group local-forms">
                                <label>Visit Remarks<span class="login-danger">*</span></label>
                              
                                <textarea id="message" name="visit_remarks"  id="remarks" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your remarks here...">{{ old('remarks') }}</textarea>

                                <div class="text-danger validation-message" data-field="visit_remarks"></div>
                            </div>

                            <!-- Follow-Up -->
                            <div class="col-12 col-md-4 form-group local-forms">
                                <label for="follow_up_date_{{ $enquiry->id }}">Follow-Up Date <span class="login-danger">*</span></label>
                                <input class="form-control" type="text" id="follow_up_date_{{ $enquiry->id }}" name="follow_up_date" placeholder="DD-MM-YYYY" oninput="formatDate(this)" maxlength="10">

                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="follow_up_date" value="n/a" id="not_fixed_{{ $enquiry->id }}" onchange="toggleFollowUpDate({{ $enquiry->id }})">
                                    <label class="form-check-label" for="not_fixed_{{ $enquiry->id }}">Not Fixed</label>
                                </div>
                                <div class="text-danger validation-message" data-field="follow_up_date"></div>
                            </div>

                            <!-- Location -->
                            <!-- <div class="col-12 col-md-6 form-group local-forms">
                                <label>Your Location (Auto Detected)</label>
                                <input type="text" id="locationInput" class="form-control mb-2" readonly />
                                <a id="googleMapLink" href="#" target="_blank" style="display: none; color: blue; text-decoration: underline;"></a> -->
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            <!-- </div> -->

                            <div class="col-md-12 mt-4 text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('user.enquiry.js_file')
@endsection