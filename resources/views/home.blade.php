@extends('layouts.apphome')

@section('content')
<!-- Success message from session -->
@if (session('success'))
<script>
    toastr.success('{{ session('
        success ') }}', 'Success', {
            closeButton: true,
            progressBar: true
        });
</script>
@endif
<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Enquiry List</h3>
                        </div>
                        <div class="col-auto text-end float-end ms-auto download-grp">

                            <a href="{{ route('enquiry.add') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>New
                                Enquiry</a>
                        </div>
                    </div>
                </div>

                <div class="response">
                    <table class="table border-0 star-student table-hover table-center mb-0 datatable table-responsive table-striped">
                        <thead class="student-thread">
                            <tr>
                                <th>ID</th>
                                <th>School Name</th>
                                <th>City</th>
                                <th>Last Visit Date</th>
                                <th>Follow Up Date</th>
                                <th>Status</th>
                                <th class="text-end">More</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enquiries as $enquiry)
                            <tr>
                                <td>{{ $enquiry->id }}</td>
                                <td>{{ $enquiry->school_name }}</td>
                                <td>{{ $enquiry->city }}</td>
                                <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
                                <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if ($enquiry->status == 0)
                                    <span class="badge bg-warning">Running</span>
                                    @elseif ($enquiry->status == 1)
                                    <span class="badge bg-success">Converted</span>
                                    @elseif ($enquiry->status == 2)
                                    <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            More
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">View</a></li>
                                            <li> <a href="{{ route('enquiry.edit', $enquiry->id) }}"
                                                    class="dropdown-item btn btn-sm">
                                                    Edit
                                                </a></li>
                                            <li><a href="#" class="btn btn-sm m-r-10 dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#full-width-modal{{ $enquiry->id }}">
                                                    Add Visit
                                                </a></li>
                                            <li><a class="dropdown-item" href="#">Add POC</a></li>
                                            <li><a class="dropdown-item" href="#">Update Flow</a></li>
                                            <li><a class="dropdown-item" href="#">Update Status</a></li>
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach ($enquiries as $enquiry)
<div id="full-width-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Add Visit</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="px-3" action="#">
                <div class="modal-body">
                    <div class="row">
                        <!-- Date of Visit -->
                        <div class="col-md-6 form-group local-forms">
                            <label>Date Of Visit <span class="login-danger">*</span></label>
                            <input class="form-control" type="text" id="visit_date_{{ $enquiry->id }}"
                                placeholder="DD-MM-YYYY" oninput="formatDate(this)" maxlength="10">
                        </div>

                        <!-- Time of Visit -->
                        <div class="col-md-6 form-group local-forms">
                            <label>Time Of Visit <span class="login-danger">*</span></label>
                            <div class="d-flex">
                                <select class="form-control me-2">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                </select>
                                <select class="form-control me-2">
                                    @for ($i = 0; $i < 60; $i +=5)
                                        <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                </select>
                                <select class="form-control">
                                    <option>AM</option>
                                    <option>PM</option>
                                </select>
                            </div>
                        </div>

                        <!-- Visit Remark -->
                        <div class="col-md-6 form-group local-forms">
                            <label for="username" class="form-label">Visit Remark</label>
                            <input class="form-control" type="text" id="username" required placeholder="Visit Remark">
                        </div>



                        <!-- Update Flow -->
                        <div class="col-md-6 form-group local-forms">
                            <label>Update Flow</label>
                            <div>
                                <div class="form-check ">
                                    <input class="form-check-input" type="radio" name="update_flow_{{ $enquiry->id }}" value="Visited">
                                    <label class="form-check-label">Visited</label>
                                </div>
                                <div class="form-check ">
                                    <input class="form-check-input" type="radio" name="update_flow_{{ $enquiry->id }}" value="Meeting Done">
                                    <label class="form-check-label">Meeting Done</label>
                                </div>
                                <div class="form-check ">
                                    <input class="form-check-input" type="radio" name="update_flow_{{ $enquiry->id }}" value="Demo Given">
                                    <label class="form-check-label">Demo Given</label>
                                </div>
                            </div>
                        </div>

                        <!-- Follow-Up Date -->
                        <div class="col-md-6 form-group local-forms">
                            <label>Follow-Up Date <span class="login-danger">*</span></label>
                            <div>
                                <input class="form-control" type="text" id="visit_date_{{ $enquiry->id }}"
                                    placeholder="DD-MM-YYYY" oninput="formatDate(this)" maxlength="10">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="follow_up_{{ $enquiry->id }}" value="Not Fixed">
                                    <label class="form-check-label">Not Fixed</label>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 form-group local-forms">
                            <label>POC</label>
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

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection