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
                    <div class="row align-items-center">
                        <div class="col align-items-center">
                            <a href="{{ route('admin.home') }}" class="text-decoration-none text-dark me-2 backButton">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <h3 class="page-title">Pending List</h3>
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
                            <input type="search" id="search-input" class="form-control form-control-sm" placeholder="Search by School/CRM Name">
                        </div>
                        <div class="col-12 col-md-2">
                            <select id="status-select" class="form-select form-select-sm">
                                <option value="">Select Status</option>
                                <option value="3">R-Converted</option>
                                <option value="4">R-Rejected</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table border-0 star-student fixed-table table-hover table-center mb-0 datatable table-responsive table-striped" id="enquiry-table">
                            <thead class="student-thread">
                                <tr>
                                    <th>S No.</th>
                                    <th>CRM Name</th>
                                    <th>School Name</th>
                                    <th>Status</th>
                                    <th >Remarks</th>
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
                                @php
                                    $visit = $enquiry->visits->first(); // Only one due to the controller limit(1)
                                @endphp

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
                                        @elseif ($visit->update_status == 3)
                                        <span class="badge bg-info text-dark">R-Converted</span>
                                        @elseif ($visit->update_status == 4)
                                        <span class="badge bg-secondary">R-Rejected</span>
                                        @endif
                                    </td>
                                    <td class="remark-cell" title="{{ $visit->visit_remarks }}">{{ $visit->visit_remarks }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('update-visit-status') }}" class="status-form">
                                            @csrf
                                            <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">
                                            <input type="hidden" name="visit_status" value="{{ $visit->update_status }}">
                                            <input type="hidden" name="visit_id" value="{{ $visit->id }}">

                                            <button type="button" class="btn btn-sm btn-primary text-white status_changes" data-status="1">Approve</button>
                                            <button type="button" class="btn btn-sm btn-danger text-white status_changes" data-status="0">Reject</button>
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
            // form.find('input[name="visit_status"]').remove(); 
            // form.append('<input type="hidden" name="visit_status" value="' + status + '">'); 

            form.find('input[name="status_code"]').remove(); 
            form.append('<input type="hidden" name="status_code" value="' + status + '">');  
            form.submit(); 
        }
    });
});
</script>

<script>
 // Trigger AJAX request when search or status changes
$('#search-input, #status-select').on('change input', function () {
    loadFilteredData();
});

function loadFilteredData() {
    var search = $('#search-input').val();
    var status = $('#status-select').val();

    // Send request with empty values if filters are cleared
    $.ajax({
        url: "{{ route('pending_request') }}",
        type: "GET",
        data: { search: search || '', status: status || '' }, // Pass empty string if fields are cleared
        success: function (response) {
            let tableBody = $('#table-body');
            tableBody.empty();

            // If no data found
            if (response.noDataFound) {
                tableBody.append('<tr><td colspan="6" class="text-center text-muted">No Data Found</td></tr>');
            } else {
                let totalCount = response.totalCount;
                let enquiries = response.enquiries;

                enquiries.forEach((enquiry, index) => {
                    let visit = enquiry.visits[0];
                    let statusLabel = getStatusLabel(visit.update_status);

                    tableBody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${enquiry.crm_user_name ?? 'No CRM User'}</td>
                            <td>${enquiry.school_name ?? 'No School Name'}</td>
                            <td>${statusLabel}</td>
                            <td class="remark-cell" title="${visit.visit_remarks}">${visit.visit_remarks}</td>
                            <td>
                                <form method="POST" action="{{ route('update-visit-status') }}" class="status-form">
                                    @csrf
                                    <input type="hidden" name="enquiry_id" value="${enquiry.id}">
                                    <input type="hidden" name="visit_status" value="${visit.update_status}">
                                    <input type="hidden" name="visit_id" value="${visit.id}">
                                    <button type="button" class="btn btn-sm btn-primary text-white status_changes" data-status="1">Approve</button>
                                    <button type="button" class="btn btn-sm btn-danger text-white status_changes" data-status="0">Reject</button>
                                </form>
                            </td>
                        </tr>
                    `);
                });

                // Update the total records button
                $('#info-btn').text(`Total Records: ${totalCount}`);
            }
        }
    });
}

// Function to get status label
function getStatusLabel(status) {
    switch (status) {
        case 3: return '<span class="badge bg-info text-dark">R-Converted</span>';
        case 4: return '<span class="badge bg-dark">R-Rejected</span>';
        default: return '';
    }
}

</script>

@include('user.modal')

@endsection
