@extends('layouts.apphome')

@section('content')

<style>
    .mandate-container {
        width: 100% !important;
    }

    .select2-container--open {
        z-index: 1088 !important;
    }

    .select2-search__field {
        z-index: 9999 !important;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">
          
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6  d-flex align-items-center">
                        <a href="{{ route('admin.crm') }}" class="text-decoration-none text-dark me-2 backButton">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <h3 class="page-title">CRM List</h3>
                        </div>
                        <form id="filterForm">
                            <div class="col-12 col-md-6 float-end text-end">
                                <select class="p-2 border rounded" id="cityFilter" name="city">
                                    <option value="">Select City</option>
                                    @forelse($cities as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                    @empty
                                    <option value="">No Cities Available</option>
                                    @endforelse
                                </select>


                                <select class="p-2 border rounded" id="crmFilter" name="crm">
                                    <option value="">Select CRM</option>
                                    @foreach($crmList as $crm)
                                    <option value="{{ $crm->id }}">{{ $crm->name }}</option>
                                    @endforeach
                                </select>

                                @if (!$noDataFound)
                                <button class="btn btn-info btn-sm" id="info-btn" disabled>Total Records:  <span id="visit_count">{{ $totalCount ?? 0 }}</span></button>
                                @endif
                              
                            </div>
                        </form>
                    </div>

                    <div class="response mt-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>S No.</th>
                                    <th>School Name</th>
                                    <th>City</th>
                                    <th>CRM Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach($enquiries as $index => $enquiry)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $enquiry->school_name }}</td>
                                    <td>{{ $enquiry->city ?? 'Not Mentioned' }}</td>
                                    <td>{{ $enquiry->user->name ?? 'Not Assigned' }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#changeCrmModal{{ $enquiry->id }}">
                                            Change
                                        </button>

                                        <div class="modal fade" id="changeCrmModal{{ $enquiry->id }}" tabindex="-1" aria-labelledby="changeCrmLabel{{ $enquiry->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.enquiry.update_crm', $enquiry->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="changeCrmLabel{{ $enquiry->id }}">Change CRM for {{ $enquiry->school_name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <select name="user_id" class="form-select select2 mandate" required style="width: 100%;">
                                                                <option class="indexing" value="">Select CRM</option>
                                                                @foreach($users as $user)
                                                                <option class="indexing" value="{{ $user->id }}" {{ ($enquiry->crm_id == $user->id) ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
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
</div>

<script>
    $(document).ready(function() {
        // Listen for filter changes and trigger the filtering
        $('#filterForm input, #filterForm select').on('change', function() {
            loadFilteredData();
        });

        // Initialize select2
        $('.select2').select2({
            placeholder: 'Select an option',
            allowClear: true,
            width: 'resolve'
        });

        // Function to load the filtered data via AJAX
        function loadFilteredData() {
            $.ajax({
                url: "{{ route('admin.assin.crm') }}", // The URL to handle the request
                type: "GET",
                data: $('#filterForm').serialize(), // Serialize the form data (filters)
                success: function(response) {
                    $('#table-body').empty(); // Clear the current table rows
                    $('#visit_count').text(response.enquiryCount);
                    // Check if we have filtered data
                    if (response.enquiries.length > 0) {
                        let rowNumber = 1;

                        // Loop through the filtered enquiries and append them to the table
                        $.each(response.enquiries, function(index, enquiry) {
                            $('#table-body').append(`
    <tr>
        <td>${rowNumber++}</td>
        <td>${enquiry.school_name}</td>
        <td>${enquiry.city || 'Not Mentioned'}</td>
        <td>${enquiry.user?.name ?? 'Not Assigned'}</td>
        <td>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#changeCrmModal${enquiry.id}">
                Change
            </button>

            <div class="modal fade" id="changeCrmModal${enquiry.id}" tabindex="-1" aria-labelledby="changeCrmLabel${enquiry.id}" aria-hidden="true">
                <div class="modal-dialog">
                    <!-- Ensure the form action uses the dynamic enquiry ID -->
                    <form action="{{ url('admin/enquiry') }}/${enquiry.id}/update-crm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="changeCrmLabel${enquiry.id}">Change CRM for ${enquiry.school_name}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <select name="user_id" class="form-select select2 mandate" required style="width: 100%;">
                                    <option value="">Select CRM</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ ($enquiry->user_id == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </td>
    </tr>
`);

                        });
                    } else {
                        // If no data is found, show a message
                        $('#table-body').append('<tr><td colspan="5" class="text-center">No data available</td></tr>');
                    }
                },
                error: function() {
                    alert('Failed to load data.');
                }
            });
        }
    });
</script>

@endsection