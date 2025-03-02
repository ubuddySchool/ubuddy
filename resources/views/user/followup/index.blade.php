@extends('layouts.apphome')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


@if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif


<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

                <div class="page-header">
                <a href="{{ route('home') }}" class="btn btn-primary float-end btn-sm">Back</a>
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Follow up List</h3>
                        </div>
                        <div class="col-auto text-end float-end ms-auto download-grp">
                            <form id="expiry-filter-form" class="d-block">
                                <div class="d-flex align-items-center">
                                    <label for="expiry_filter_switch" class="form-label me-2 mb-0">Last Expiry Date</label>
                                    
                                        <div class="form-check form-switch">
                                           
                                            <input type="checkbox" id="expiry_filter_switch" role="switch" class="form-check-input"name="expiry_filter" value="expired"
                                        {{ request('expiry_filter') == 'expired' ? 'checked' : '' }} data-toggle="toggle" data-on="Expired" data-off="Not Expired">
                                           </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="response">
                        <table class="table border-0 star-student table-hover table-center mb-0 datatable table-responsive table-striped" id="enquiry-table">
                            <thead class="student-thread">
                                <tr>
                                    <th>S No.</th>
                                    <th>School Name</th>
                                    <th>Last Visit Date</th>
                                    <th>Follow Up Date</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th class="w-10">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach ($enquiries as $enquiry)
                                <tr>
                                    <td>{{ $enquiry->id }}</td>
                                    <td>{{ $enquiry->school_name }}</td>
                                    <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @if ($enquiry->status == 0)
                                        <span class="badge bg-warning">Running</span>
                                        @elseif ($enquiry->status == 1)
                                        <span class="badge bg-success">Converted</span>
                                        @elseif ($enquiry->status == 2)
                                        <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $enquiry->remarks }}</td>
                                    <td><a href="#" class="dropdown-item btn btn-sm btn-primary " style="background-color: #4040ff;color:white;"data-bs-toggle="modal" data-bs-target="#add-remark-modal{{ $enquiry->id }}">Add Remark</a>
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


@include('user.modal')



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
//    $(document).ready(function() {
   
//     $('#expiry_filter_switch').change(function() {
//         var filterValue = $(this).prop('checked') ? 'expired' : 'not_expired'; 
//         updateTable(filterValue); 
//     });

//     function updateTable(filterValue) {
//         $.ajax({
//             url: '', 
//             type: 'GET',
//             data: { 
//                 expiry_filter: filterValue 
//             },
//             success: function(response) {
//                 $('#table-body').html(response.html); 
//             },
//             error: function(xhr, status, error) {
//                 console.error("Error fetching filtered data:", error);
//             }
//         });
//     }
// });

</script>

@endsection