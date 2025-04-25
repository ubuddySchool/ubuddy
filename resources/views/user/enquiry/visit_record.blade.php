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
                                <h3 class="page-title">Visit List</h3>
                            </div>
                        </div>
                    </div>

                <div class="page-header">
                    <div class="row align-items-center justify-content-between gap-3">
                        

                        <div class="col-12 col-md-12 mb-3 mb-md-0">
                            <!-- Filter Form -->
                            <form id="filterForm">
                           
                                <div class="d-flex flex-column flex-md-row align-items-center gap-3 gap-md-2 justify-content-between">
                                <div class="col-md-3 d-flex align-items-center gap-2">
                                        <input type="date" id="from_date" name="from_date" class="form-control form-control-sm"
                                            value="{{ request('from_date') }}">
                                    <div class="d-flex align-items-center">
                                        <label for="to_date" class="form-label mb-0 me-1">To</label>
                                        <input type="date" id="to_date" name="to_date" class="form-control form-control-sm"
                                            value="{{ request('to_date') }}">
                                    </div>
                                </div>

                                    <div class="col-md-3">
                                        <select id="contact_method" name="contact_method" class="form-select form-control-sm">
                                            <option value="">Visit Type</option>
                                            <option value="1" {{ request('contact_method') == '1' ? 'selected' : '' }}>In-person</option>
                                            <option value="0" {{ request('contact_method') == '0' ? 'selected' : '' }}>Telephonic</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <select id="visit_type" name="visit_type" class="form-select form-control-sm">
                                            <option value="">Meeting Type</option>
                                            <option value="New Meeting" {{ request('visit_type') == 'New Meeting' ? 'selected' : '' }}>New Meeting</option>
                                            <option value="Follow-up" {{ request('visit_type') == 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input mb-0" type="checkbox" name="today_visit" value="today" id="today_visit"
                                               {{ request('today_visit') == 'today' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="today_visit">Today's Visits Only</label>
                                    </div>
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
                                <th>Visit Date</th>
                                <th>Visit Type</th>
                                <th>Meeting Type</th>
                                <th>View Details</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <!-- Data will be populated via AJAX -->
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
