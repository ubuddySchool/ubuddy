@extends('layouts.apphome')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                            <div id="info-container" class="mb-2">
                                <button class="btn btn-info btn-sm" id="info-btn" disabled>
                                    Total Records: {{ $totalCount }}
                                </button>
                            </div>
                            @endif
                        </div>
                        <div class="col-12 col-md-3 text-end float-end ms-auto download-grp">
                            <input type="search" class="form-control form-control-sm" placeholder="Search by School/CRM Name">
                        </div>
                        <div class="col-12 col-md-2">
                            <select class="form-select form-select-sm">
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

                                            <button type="button" class="btn btn-sm btn-primary text-white status_changes" data-status="1">Approve</button>
                                            <button type="button" class="btn btn-sm btn-danger text-white status_changes" data-status="2">Reject</button>
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

{{-- SweetAlert2 Confirmation Script --}}
<script>
    $(document).on('click', '.status_changes', function (e) {
        e.preventDefault();

        var status = $(this).data('status');
        var form = $(this).closest('form');
        var schoolName = $(this).closest('tr').find('td:nth-child(3)').text().trim();

        var actionText = status === 1 ? 'approve' : 'deny';
        var statusText = status === 1 ? 'Converted' : 'Rejected';
        var confirmButtonText = status === 1 ? 'Yes, Approve it!' : 'Yes, Reject it!';
        var confirmButtonColor = status === 1 ? '#28a745' : '#dc3545';

        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to ${actionText} "${schoolName}" to change to "${statusText}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: confirmButtonColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmButtonText
        }).then((result) => {
            if (result.isConfirmed) {
                form.find('input[name="status"]').remove();
                form.append('<input type="hidden" name="status" value="' + status + '">');
                form.submit();
            }
        });
    });
</script>

@include('user.modal')
@endsection
