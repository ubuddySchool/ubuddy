@extends('layouts.apphome')

@section('content')


<div class="content container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

            <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6 d-flex align-items-center">
                                <a href="{{ route('home') }}" class="text-decoration-none text-dark me-2 backButton">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <h3 class="page-title">Follow-up List</h3>
                            </div>
                        <div class="col-12 col-md-6 text-end float-end btn-sm ms-auto download-grp">
                            <div class="d-flex flex-wrap justify-content-end">
                                <a href="{{ route('expired_follow_up') }}" class="bg-green-500 text-white p-2 rounded mb-2 sm:mb-0 me-2">Expired follow up</a>
                            </div>
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

@include('user.modal')
<script>
 $(document).ready(function() {
    $('#filterForm input, #filterForm select').on('change', function() {
        loadFilteredData();
    });

    function loadFilteredData() {
        $.ajax({
            url: "{{ route('visit_record') }}",  
            type: 'GET',
            data: $('#filterForm').serialize(),
            success: function(response) {
                $('#table-body').empty();

                if (response.enquiries.length > 0) {
                    let rowNumber = response.rowNumber;                    
                    // Helper function to format date
                    function formatDate(isoDate) {
                        if (!isoDate) return 'NULL'; // or return ''; or '—'

                        const date = new Date(isoDate);
                        if (isNaN(date)) return 'NULL'; // Handle invalid dates

                        const day = String(date.getDate()).padStart(2, '0');
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const year = date.getFullYear();
                        return `${day}-${month}-${year}`;
                    }

                    $.each(response.enquiries, function(index, enquiry) {
                        $.each(enquiry.visits, function(i, visit) {
                            let visitType = (visit.visit_type == 1) ? 'New Meeting' : 'Follow-up';
                            let contactMethod = (visit.contact_method == 1) ? 'In-person' : 'Telephonic';
                            let formattedDate = formatDate(visit.date_of_visit);
                            let formatted_follow_up_date = formatDate(visit.follow_up_date);
                            $('#table-body').append(`
                                <tr>
                                    <td>${rowNumber++}</td>
                                    <td>${enquiry.school_name || 'No School Name'}</td>
                                        <td>${formattedDate}</td>
                                        <td>${visit.visit_remarks}</td>
                                        <td>${formatted_follow_up_date}</td>
                                    <td><a href="#" class=" bg-info btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#view-modal${enquiry.id}">View Details</a></td>
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