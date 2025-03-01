@foreach ($enquiries as $enquiry)
<div id="full-width-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullWidthModalLabel">Add Visit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="px-3" action="#">
                <div class="modal-body">
                    <div class="row">
                        <!-- Date of Visit -->
                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="visit_date_{{ $enquiry->id }}">Date Of Visit <span class="login-danger">*</span></label>
                            <input class="form-control" type="text" id="visit_date_{{ $enquiry->id }}" placeholder="DD-MM-YYYY" oninput="formatDate(this)" maxlength="10">
                        </div>

                        <!-- Time of Visit -->
                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="time_of_visit_{{ $enquiry->id }}">Time Of Visit <span class="login-danger">*</span></label>
                            <div class="d-flex">
                                <select class="form-control me-2" style="max-width: 60px;">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                    @endfor
                                </select>
                                <select class="form-control me-2" style="max-width: 60px;">
                                    @for ($i = 0; $i < 60; $i += 5)
                                        <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                    @endfor
                                </select>
                                <select class="form-control" style="max-width: 60px;">
                                    <option>AM</option>
                                    <option>PM</option>
                                </select>
                            </div>
                        </div>

                        <!-- Visit Remark -->
                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="visit_remark_{{ $enquiry->id }}" class="form-label">Visit Remark</label>
                            <input class="form-control" type="text" id="visit_remark_{{ $enquiry->id }}" required placeholder="Visit Remark">
                        </div>

                        <!-- Update Flow -->
                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="update_flow_{{ $enquiry->id }}">Update Flow</label>
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

                        <!-- Contact Method -->
                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="contact_method_{{ $enquiry->id }}">Contact Method</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contact_method_{{ $enquiry->id }}" value="Telephonic">
                                    <label class="form-check-label">Telephonic</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contact_method_{{ $enquiry->id }}" value="In Person Meeting">
                                    <label class="form-check-label">In Person Meeting</label>
                                </div>
                            </div>
                        </div>

                        <!-- Follow-Up Date -->
                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="follow_up_date_{{ $enquiry->id }}">Follow-Up Date <span class="login-danger">*</span></label>
                            <input class="form-control" type="text" id="follow_up_date_{{ $enquiry->id }}" placeholder="DD-MM-YYYY" oninput="formatDate(this)" maxlength="10">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" name="follow_up_{{ $enquiry->id }}" value="Not Fixed">
                                <label class="form-check-label">Not Fixed</label>
                            </div>
                        </div>

                        <!-- POC -->
                        <div class="col-12 col-md-6 form-group local-forms">
                            <label for="poc_{{ $enquiry->id }}">POC</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="poc_{{ $enquiry->id }}" value="{{ $enquiry->id }}">
                                    <label class="form-check-label">{{ $enquiry->poc_name }}</label>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary mt-2" onclick="showPocForm({{ $enquiry->id }})">Add POC</button>

                                <!-- Hidden POC Form -->
                                <div id="poc-form-{{ $enquiry->id }}" class="mt-3" style="display: none;">
                                    <input type="text" class="form-control mb-2" id="new_poc_name_{{ $enquiry->id }}" placeholder="Enter POC Name">
                                    <input type="text" class="form-control mb-2" id="new_poc_contact_{{ $enquiry->id }}" placeholder="Enter POC Contact">
                                    <button type="button" class="btn btn-success btn-sm" onclick="saveNewPoc({{ $enquiry->id }})">Save</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hidePocForm({{ $enquiry->id }})">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Submit</button>
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
<div id="view-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $enquiry->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="viewModalLabel{{ $enquiry->id }}">View Enquiry Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Existing Content in Grid -->
                <div class="row">
                    <div class="col-12 col-md-6">
                        <p><strong>School Name:</strong> {{ $enquiry->school_name }}</p>
                        <p><strong>Board:</strong> {{ $enquiry->board }}</p>
                        <p><strong>Address:</strong> {{ $enquiry->address }}</p>
                        <p><strong>Pin code:</strong> {{ $enquiry->pincode }}</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p><strong>City:</strong> {{ $enquiry->city }}</p>
                        <p><strong>State:</strong> {{ $enquiry->state }}</p>
                        <p><strong>Website:</strong> {{ $enquiry->website }}</p>
                        <p><strong>Last Visit Date:</strong> {{ $enquiry->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>

                <!-- New Table Below -->
                <div class="mt-4">
                    <table class="table table-striped table-info table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Visit Date</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
                                <td>remark</td>
                            </tr>

                            {{--@foreach ($enquiry->visits as $index => $visit)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                            <td>{{ $visit->date->format('Y-m-d') }}</td>
                            <td>{{ $visit->remark }}</td>
                            </tr>
                            @endforeach--}}
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
                <h4 class="modal-title" id="viewModalLabel{{ $enquiry->id }}">View Enquiry Details</h4>
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