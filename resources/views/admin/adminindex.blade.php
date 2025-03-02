@extends('layouts.apphome')

@section('content')



    <div class="container-fluid mx-auto px-4 sm:px-6 md:px-8 mb-5 py-5">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-3xl font-bold mb-4 sm:mb-0">Enquiries Dashboard</h1>
            <div class="flex flex-wrap gap-2">
                <button class="bg-yellow-500 text-white p-2 rounded mb-2 sm:mb-0">Pending Request</button>
                <button class="bg-green-500 text-white p-2 rounded mb-2 sm:mb-0">Follow Up</button>
                <button class="bg-blue-500 text-white p-2 rounded mb-2 sm:mb-0">Download</button>
            </div>
        </div>


        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold mb-4">Enquiries</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <select class="p-2 border rounded"><option>Select CRM</option></select>
            <select class="p-2 border rounded"><option>Select City</option></select>
            <select class="p-2 border rounded"><option>Select Status</option></select>
            <select class="p-2 border rounded"><option>Select Flow</option></select>
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

    <script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            processing: false,
            serverSide: true,
            ajax: "{{ route('admin.home') }}", 
            columns: [
                {data: 'id', name: 'id'},
                {data: 'school_name', name: 'school_name'},
                {data: 'user_id', name: 'user_id'}, 
                {data: 'city', name: 'city'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
                
            ],
            initComplete: function () {
                var searchInput = $('#DataTables_Table_0_filter input');

                searchInput.addClass('form-control-lg border rounded'); 
                searchInput.attr('placeholder', 'Search by Pin Code, School Name, CRM Name');

                $('#DataTables_Table_0_filter label').contents().filter(function() {
                    return this.nodeType === 3;
                }).remove(); 
            }
        });
    });
</script>








@endsection
