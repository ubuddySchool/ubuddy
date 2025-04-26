@extends('layouts.apphome')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">
                <div class="page-header d-flex align-items-center mb-3">
                <a href="{{ route('admin.home') }}" class="text-decoration-none text-dark me-2 backButton">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                    <h3 class="page-title">Visit List</h3>
                </div>
              



                <form id="filterForm">
                    <div class="row g-2 mb-4">
                        <div class="col-md-2">
                            <input type="date" name="from_date" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="to_date" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2">
                            <select name="contact_method" class="form-select form-select-sm">
                                <option value="">Visit Type</option>
                                <option value="1">In Person</option>
                                <option value="0">Telephonic</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="visit_type" class="form-select form-select-sm">
                                <option value="">Meeting Type</option>
                                <option value="New Meeting">New Meeting</option>
                                <option value="Follow-up">Follow-up</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="crm_user" class="form-select form-select-sm select2">
                                <option value="">CRM Filter</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>


                <!-- Visit count -->
                <button class="btn btn-primary mb-3" disabled>
                    No. of Visits: <span id="visit_count">{{ $enquiryCount ?? 0 }}</span>
                </button>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-striped" id="visit_table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>School Name</th>
                                <th>CRM Name</th>
                                <th>Visit Date</th>
                                <th>Visit Type</th>
                                <th>Meeting Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @php $row = 1; @endphp
                            @foreach ($enquiries as $enquiry)
                            @foreach ($enquiry->visits as $visit)
                            <tr>
                                <td>{{ $row++ }}</td>
                                <td>{{ $enquiry->school_name ?? 'N/A' }}</td>
                                <td>{{ $enquiry->user->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($visit->date_of_visit)->format('d-m-Y') }}</td>
                                <td>{{ $visit->contact_method == 1 ? 'In Person' : 'Telephonic' }}</td>
                                <td>{{ $visit->visit_type == 1 ? 'New Meeting' : 'Follow-up' }}</td>
                                <td><a href="#" class="btn btn-sm btn-info text-light">View</a></td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
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
                url: "{{ route('admin.visit_record') }}",
                type: 'GET',
                data: $('#filterForm').serialize(),
                success: function(response) {
                    $('#table-body').empty();
                    $('#visit_count').text(response.enquiryCount);
                    if (response.enquiries.length > 0) {
                        let rowNumber = response.rowNumber || 1;

                        $.each(response.enquiries, function(index, enquiry) {
                            $.each(enquiry.visits, function(i, visit) {
                                let visitType = (visit.visit_type == 1) ? 'New Meeting' : 'Follow-up';
                                let contactMethod = (visit.contact_method == 1) ? 'In-person' : 'Telephonic';

                                $('#table-body').append(`
                                    <tr>
                                        <td>${rowNumber++}</td>
                                        <td>${enquiry.school_name || 'No School Name'}</td>
                                        <td>${enquiry.user?.name ?? 'N/A'}</td>
                                        <td>${formatDate(visit.date_of_visit)}</td>
                                       <td>${contactMethod}</td>
                                        <td>${visitType}</td>
                                        <td><a href="#" class="btn btn-sm btn-info text-light" data-bs-toggle="modal" data-bs-target="#view-modal${enquiry.id}">View</a></td>
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

        function formatDate(dateString) {
    const date = new Date(dateString);
    if (isNaN(date)) return 'Invalid Date';

    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
    const year = date.getFullYear();

    return `${day}-${month}-${year}`;
}


        // Load initial data
        loadFilteredData();
    });


  // Handle select2 change properly
$('.select2').on('change', function() {
    $('#filterForm').trigger('change');
});


 
</script>

@endsection