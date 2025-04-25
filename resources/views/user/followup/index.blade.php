@extends('layouts.apphome')

@section('content')


<div class="content container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

            <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col align-items-center">
                                <a href="{{ route('home') }}" class="text-decoration-none text-dark me-2 backButton">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <h3 class="page-title">Follow-up List</h3>
                            </div>
                        </div>
                    </div>

                <div class="page-header">
                    <div class="row align-items-center">
                       
                        <div class="col-12 col-md-12 ms-auto download-grp">
                            <form id="filterForm">
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="response mt-3">
                    <table class="table border-0 star-student table-hover table-center mb-0 datatable table-responsive table-striped" id="enquiry-table">
                        <thead class="student-thread">
                            <tr>
                                <th>S No.</th>
                                <th>School Name</th>
                                <th>Last Visit Date</th>
                                <th>Remarks</th>
                                <th>Follow Up</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @if($noDataFound)
                            <tr>
                                <td colspan="5" class="text-center text-muted">No Data Found</td>
                            </tr>
                            @else
                            @php $serial = 1; @endphp
                            @foreach ($enquiries as $enquiry)
                            @foreach ($enquiry->visits as $visit)
                            <tr>
                                <td>{{ $serial++ }}</td>
                                <td>{{ $enquiry->school_name ?? 'No School Name' }}</td>
                                <td>{{ \Carbon\Carbon::parse($visit->date_of_visit)->format('d-m-Y') }}</td>
                                <td>Remarks</td>
                                <td>{{ $visit->follow_up_date }}</td>
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
 $(document).ready(function() {
    // Listen for changes in the filter form
    $('#filterForm input, #filterForm select').on('change', function() {
        loadFilteredData();
    });

    // Load filtered data via AJAX
    function loadFilteredData() {
        $.ajax({
            url: "{{ route('visit_record') }}",  // The route to fetch filtered data
            type: 'GET',
            data: $('#filterForm').serialize(), // Serialize the form data (including dates)
            success: function(response) {
                $('#table-body').empty();

                if (response.enquiries.length > 0) {
                    let rowNumber = response.rowNumber;
                    $.each(response.enquiries, function(index, enquiry) {
                        $.each(enquiry.visits, function(i, visit) {
                            let visitType = (visit.visit_type == 1) ? 'New Meeting' : 'Follow-up';
                            let contactMethod = (visit.contact_method == 1) ? 'In-person' : 'Telephonic';
                            $('#table-body').append(`
                                <tr>
                                    <td>${rowNumber++}</td>
                                    <td>${enquiry.school_name || 'No School Name'}</td>
                                    <td>${visit.date_of_visit}</td>
                                    <td>${contactMethod}</td>
                                    <td>${visitType}</td>
                                    <td><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-modal${enquiry.id}">View Details</a></td>
                                </tr>
                            `);
                        });
                    });
                } else {
                    $('#table-body').append('<tr><td colspan="6" class="text-center">No data available</td></tr>');
                }
            },
            error: function() {
                alert('Failed to load data.');
            }
        });
    }

    loadFilteredData();
});

    
</script>


@endsection