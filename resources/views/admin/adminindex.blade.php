@extends('layouts.apphome')

@section('content')

<div class="container-fluid mx-auto px-4 sm:px-6 md:px-8 mb-5 py-5">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl font-bold mb-4 sm:mb-0">Enquiries Dashboard</h1>
        <div class="flex flex-wrap gap-2">
           <a href="{{ route('admin.crm') }}" class="bg-pink-500 text-white p-2 rounded mb-2 sm:mb-0 me-2">CRM</a>
           <a href="{{ route('pending_request') }}" class="bg-yellow-500 text-white p-2 rounded mb-2 sm:mb-0 me-2">Pending Request: {{ $totalPending }}</a>
           <a href="{{ route('admin.visit_record') }}" class="bg-blue-500 text-white p-2 rounded mb-2 sm:mb-0 me-2">Visit Record</a>
           <a href="{{ route('admin.expired_follow_up') }}" class="bg-green-500 text-white p-2 rounded mb-2 sm:mb-0 me-2">Expired follow up</a>
            <a href="{{ route('follow_up.admin') }}" class="bg-purple-500 text-white p-2 rounded mb-2 sm:mb-0 me-2">Follow up</a>
           
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-4">
        <h2 class="text-xl font-semibold mb-4">Enquiries</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <select class="p-2 border rounded w-full" id="crm-filter">
                <option value="">Select CRM</option>
                @foreach($crms as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            
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

            <select id="flow-filter" class="p-2 border rounded w-full">
                <option value="">Select Flow</option>
                @foreach($flows as $key => $flow)
                    <option value="{{ $key }}">{{ $flow }}</option>
                @endforeach
            </select>
        </div>

        <table class="table table-bordered data-table">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">S. No.</th>
                    <th class="p-2">School Name</th>
                    <th class="p-2">CRM Name</th>
                    <th class="p-2">City</th>
                    <th class="p-2">Last Visit Date</th>
                    <th class="p-2">Follow Up Date</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $('.data-table').DataTable({
            processing: false,
            serverSide: true,
            paging: false,
            info: true,
            ajax: {
                url: '{{ route('admin.home') }}',
                data: function(d) {
                    d.city = $('#city-filter').val();
                    d.status = $('#status-filter').val();
                    d.flow = $('#flow-filter').val();
                    d.crm = $('#crm-filter').val();  // Pass the CRM filter
                }
            },
            // order: [
            //     [2, 'desc']
            // ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'school_name',
                    name: 'school_name',
                    orderable: false
                },
                {
                    data: 'crm_name', 
                    name: 'crm_name',
                    orderable: false
                },
                {
                    data: 'city',
                    name: 'city',
                    orderable: false
                },
                {
                    data: 'last_visit',
                    name: 'last_visit',
                    orderable: false
                },
                {
                    data: 'follow_up_date',
                    name: 'follow_up_date',
                    orderable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    render: function(data) {
                        if (data == 0) return '<span class="badge bg-warning">Running</span>';
                        if (data == 1) return '<span class="badge bg-success">Converted</span>';
                        if (data == 2) return '<span class="badge bg-danger">Rejected</span>';
                        return '<span class="badge bg-secondary">Unknown</span>';
                    }
                },
                {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var id = row.id;
                    return `
                     <a href="#" class=" btn btn-sm btn-info " data-bs-toggle="modal" data-bs-target="#view-modal${id}">
                                        View Details
                     </a>
                        
                    `;
                }
            }
            ],
            initComplete: function() {
                var searchInput = $('#DataTables_Table_0_filter input');
                searchInput.addClass('form-control-sm border rounded');
                searchInput.attr('placeholder', 'Search by Pin Code, School Name,CRM Name');
                $('#DataTables_Table_0_filter label').contents().filter(function() {
                    return this.nodeType === 3;
                }).remove();
            },
            drawCallback: function(settings) {
                var tableInfo = $('.dataTables_info').text();
                var totalEntries = tableInfo.match(/\d+/g)?.pop() || 0;
                var filteredCount = table.page.info().recordsDisplay;

                var infoButton = `<button class="btn btn-info btn-sm" id="info-btn">Total Enquiry: ${filteredCount}</button>`;
                $('#info-container').html(infoButton);
            }
        });
        $('.dataTables_filter').prepend('<div id="info-container" class="mb-2"></div>');

        // Listen for changes on the filters and redraw the table
        $('#city-filter, #status-filter, #flow-filter, #crm-filter').change(function() {
            table.draw();
        });
    });
</script>

@include('user.modal')

@endsection
