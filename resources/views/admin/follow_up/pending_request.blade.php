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
                                    <div class="d-flex align-items-center gap-2">
                                        <label for="from_date" class="form-label mb-0">From:</label>
                                        <input type="date" id="from_date" name="from_date" class="form-control form-control-sm"
                                            value="{{ request('from_date') }}">
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <label for="to_date" class="form-label mb-0">To:</label>
                                        <input type="date" id="to_date" name="to_date" class="form-control form-control-sm"
                                            value="{{ request('to_date') }}">
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                        <a href="{{ route('follow_up.admin') }}" class="btn btn-secondary btn-sm">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                    <div class="response mt-3">
                        <table class="table border-0 star-student table-hover table-center mb-0 datatable table-responsive table-striped" id="enquiry-table">
                            <thead class="student-thread">
                                <tr>
                                    <th>S No.</th>
                                    <th>CRM Name</th>
                                    <th>School Name</th>
                                    <th>Visit Date</th>
                                    <th>Follow Up</th>
                                    <th>Remarks</th>
                                    <th>status</th>
                                    <th>Set Status</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @if($noDataFound)
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No Data Found</td>
                                </tr>
                                @else
                                @foreach ($enquiries as $enquiry)
                                @foreach ($enquiry->visits as $visit)
                                <tr>
                                    <td>{{ $loop->parent->index + 1 }}</td>
                                    <td>{{ $enquiry->crm_user_name ?? 'No CRM User' }}</td>
                                    <td>{{ $enquiry->school_name ?? 'No School Name' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($visit->date_of_visit)->format('d-m-Y') }}</td>
                                    <td>
    @if($visit->follow_up_date && $visit->follow_up_date !== 'n/a')
        {{ \Carbon\Carbon::parse($visit->follow_up_date)->format('d-m-Y') }}
    @else
        {{ $visit->follow_na }}
    @endif
</td>


                                    <td>{{ $visit->visit_remarks }}</td>
                                    <td>
                                        @if ($enquiry->status == 0)
                                        <span class="badge bg-warning">Running</span>
                                        @elseif ($enquiry->status == 1)
                                        <span class="badge bg-success">Converted</span>
                                        @elseif ($enquiry->status == 2)
                                        <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>

                                    <td>
                                        <!-- Form with dropdown -->
                                        <form method="POST" action="{{ route('update-visit-status') }}" class="status-form">
                                            @csrf
                                            <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Update Status
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                                    <li><a class="dropdown-item" href="#" data-status="0">Running</a></li>
                                                    <li><a class="dropdown-item" href="#" data-status="1">Converted</a></li>
                                                    <li><a class="dropdown-item" href="#" data-status="2">Rejected</a></li>
                                                </ul>
                                            </div>
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
    $(document).on('click', '.dropdown-item', function() {
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