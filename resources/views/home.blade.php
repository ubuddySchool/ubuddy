@extends('layouts.apphome')

@section('content')


<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body mt-3">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <h3 class="page-title">Enquiry List</h3>
                        </div>
                        <div class="col-12 col-md-6 text-end float-end btn-sm ms-auto download-grp">
                            <div class="d-flex flex-wrap justify-content-end">
                                {{-- <a href="{{ route('expired_follow_up') }}" class="bg-green-500 text-white p-2 rounded mb-2 sm:mb-0 me-2">Expired follow up</a> --}}
                                <a href="{{ route('visit_record') }}" class="bg-blue-500 text-white p-2 rounded mb-2 sm:mb-0 me-2">Visit Record</a>
                                <a href="{{ route('follow_up') }}" class="bg-purple-500 text-white p-2 rounded mb-2 sm:mb-0 me-2">Follow up</a>
                                <a href="{{ route('enquiry.add') }}" class="bg-indigo-500 btn-sm text-white p-2 rounded mb-2 sm:mb-0"><i class="fas fa-plus me-2"></i>New Enquiry</a>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Add Select Dropdowns for Filters -->
                <div class="container-fluid mx-auto px-4 sm:px-6 md:px-8 my-3 bg-light p-3 rounded">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <select id="city-filter" class="p-2 border rounded w-full">
                            <option value="">Select City</option>
                            @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>

                        <select id="status-filter" class="p-2 border rounded w-full">
                            <option value="">Select Status</option>
                            @foreach($statuses as $key => $status)
                            <option value="{{ $key }}">{{ $status }}</option>
                            @endforeach
                        </select>


                    </div>
                </div>
                <div class="table-responsive">
                    <div class="response bg-light p-3 rounded">
                        <table class="table table-bordered data-table  table-responsive w-100">
                            <thead class="student-thread">
                                <tr>
                                    <th>S.No.</th>
                                    <th>School Name</th>
                                    <th>City</th>
                                    <th>Last Visit</th>
                                    <th>Follow Up</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
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
        var table = $('.data-table').DataTable({
            processing: false,
            serverSide: true,
            paging: false,
            orderable: false,
            info: true,
            ajax: {
                url: '{{ route('home') }}',
                data: function(d) {
                    d.city = $('#city-filter').val();
                    d.status = $('#status-filter').val();
                    d.flow = $('#flow-filter').val();
                }
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'school_name',
                    name: 'school_name',
                    orderable: false
                },
                {
                    data: 'city',
                    name: 'city',
                    orderable: false,
                },
                {
                    data: 'last_visit',
                    name: 'last_visit',
                    orderable: false
                },
                {
                    data: 'follow_up_date',
                    name: 'follow_up_date',
                    orderable: false,
                    render: function(data, type, row) {
                        if (data == null || data === 'N/A') {
                            return row.follow_na || 'N/A';
                        }
                        return data;
                    }
                },
                {
                    data: 'update_status',
                    name: 'update_status',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return data;
                    }
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        var id = row.id;
                        const pocRoute = "{{ route('poclist', ':id') }}".replace(':id', id);
                        const visits = "{{ route('add.visit', ':id') }}".replace(':id', id);
                        const details = "{{ route('view.details', ':id') }} ".replace(':id', id);
                        const edit_enquiry = "{{ route('edit.enquiry.crm', ':id') }} ".replace(':id', id);
                        return `
                        <div class="dropdown">
                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                More
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="${pocRoute}" class="btn btn-sm m-r-10 dropdown-item">
                                         Add/Edit POC
                                    </a>
                                </li>
                                <li>
                                    <a href="${visits}" class="btn btn-sm m-r-10 dropdown-item" >
                                        Add Visit
                                    </a>
                                </li>
                                <li>
                                    <a href="${details}" class="btn btn-sm m-r-10 dropdown-item">
                                        View Details
                                    </a>
                                </li>
                                <li>
                                    <a href="${edit_enquiry}" class="btn btn-sm m-r-10 dropdown-item">
                                        Edit
                                    </a>
                                </li>
                            </ul>
                        </div>
                    `;
                    }
                }
            ],
            initComplete: function() {
                var searchInput = $('#DataTables_Table_0_filter input');
                searchInput.addClass('form-control-sm border rounded');
                searchInput.attr('placeholder', 'Search by Pin Code, School Name');
                $('#DataTables_Table_0_filter label').contents().filter(function() {
                    return this.nodeType === 3;
                }).remove();
            },
            drawCallback: function(settings) {
                var tableInfo = $('.dataTables_info').text();
                var totalEntries = tableInfo.match(/\d+/g)?.pop() || 0;
                var filteredCount = table.page.info().recordsDisplay;

                var infoButton = `<button class="btn btn-info btn-sm" id="info-btn" disabled>Total Enquiry: ${filteredCount}</button>`;
                $('#info-container').html(infoButton);
            }
        });
        $('.dataTables_filter').prepend('<div id="info-container" class="mb-2"></div>');

        $('#city-filter, #status-filter, #flow-filter').change(function() {
            table.draw();
        });
    });
</script>
@include('user.enquiry.js_file')

<!-- <a href="{{ route('poclist') }}" class="btn btn-sm m-r-10 dropdown-item" data-bs-toggle="modal" data-bs-target="#add-poc-modal${id}"></a> -->

@endsection