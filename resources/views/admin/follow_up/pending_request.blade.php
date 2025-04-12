@extends('layouts.apphome')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

                <div class="page-header">
                    <a href="{{ route('admin.home') }}" class="btn btn-primary float-end btn-sm">Back</a>
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <h3 class="page-title">Pending List</h3>
                        </div>
                        <div class="col-12 col-md-6 text-end float-end ms-auto download-grp">
                            <form method="GET" action="{{ route('pending_request') }}">
                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                    <!-- Removed Date Filters -->
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row align-items-center mt-3">
                        <div class="col-12 col-md-6">
                        @if (!$noDataFound)
                    <div id="info-container" class="mb-2"><button class="btn btn-info btn-sm" id="info-btn" disabled>Total Records: {{ $totalCount }}</button></div>
                    @endif
                        </div>
                        <div class="col-12 col-md-3 text-end float-end ms-auto download-grp">
                           <input type="search" class="form-control" name="" placeholder="Search by School/CRM Name" id="">
                        </div>
                        <div class="col-12 col-md-2 ">
                            <select name="" id="" class="form-control">
                                <option value="">Select Status</option>
                                <option value="">Converted</option>
                                <option value="">Rejected</option>

                            </select>     
                                           </div>
                    </div>

                    

                    <div class="response mt-3">
                        <table class="table border-0 star-student table-hover table-center mb-0 datatable table-responsive table-striped" id="enquiry-table">
                            <thead class="student-thread">
                                <tr>
                                    <th>S No.</th>
                                    <th>CRM Name</th>
                                    <th>School Name</th>
                                    <th>Requested Status</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @if($noDataFound)
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No Data Found</td>
                                </tr>
                                @else
                                @foreach ($enquiries as $enquiry)
                                    @foreach ($enquiry->visits as $visit)
                                    <tr>
                                        <td>{{ $loop->parent->index + 1 }}</td>
                                        <td>{{ $enquiry->crm_user_name ?? 'No CRM User' }}</td>
                                        <td>{{ $enquiry->school_name ?? 'No School Name' }}</td>
                                        <td>
                                            @if ($visit->update_status == 0)
                                            <span class="badge bg-warning">Running</span>
                                            @elseif ($visit->update_status == 1)
                                            <span class="badge bg-success">Converted</span>
                                            @elseif ($visit->update_status == 2)
                                            <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $visit->visit_remarks }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('update-visit-status') }}" class="status-form">
                                                @csrf
                                                <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">
                                                <a class="btn btn-sm btn-primary text-white status_changes" href="#" data-status="1">Approve</a>
                                                <a class="btn btn-sm btn-danger text-white status_changes" href="#" data-status="2">Reject</a>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle the dropdown item click and submit the form
    $(document).on('click', '.status_changes', function() {
        var status = $(this).data('status');
        var form = $(this).closest('form');

        // Set the status in the hidden input before submitting the form
        form.find('input[name="status"]').remove(); // Remove any existing status input
        form.append('<input type="hidden" name="status" value="' + status + '">');

        // Submit the form
        form.submit();
    });
</script>

@include('user.modal')
@endsection
