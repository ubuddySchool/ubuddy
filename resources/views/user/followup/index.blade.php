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
                        <form method="GET" action="{{ route('follow_up') }}">
                            <div class="d-flex align-items-center gap-2">
                                <label for="from_date" class="form-label mb-0">From:</label>
                                <input type="date" id="from_date" name="from_date" class="form-control form-control-sm" 
                                    value="{{ request('from_date') }}">
                                
                                <label for="to_date" class="form-label mb-0">To:</label>
                                <input type="date" id="to_date" name="to_date" class="form-control form-control-sm" 
                                    value="{{ request('to_date') }}">

                                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                <a href="{{ route('follow_up') }}" class="btn btn-secondary btn-sm">Reset</a>
                            </div>
                        </form>


                        </div>

                        
                    </div>


                    <div class="response mt-3">
                        <table class="table border-0 star-student table-hover table-center mb-0 datatable table-responsive table-striped" id="enquiry-table">
                            <thead class="student-thread">
                                <tr>
                                    <th>S No.</th>
                                    <th>School Name</th>
                                    <th>Visit Date</th>
                                    <th>Follow Up</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                            @foreach ($enquiries as $enquiry)
                                @foreach ($enquiry->visits as $visit)
                                    <tr>
                                        <td>{{ $loop->parent->index + 1 }}</td>
                                        <td>{{ $enquiry->school_name ?? 'No School Name' }}</td>
                                        <td>{{ $visit->date_of_visit }}</td>
                                        <td>{{ $visit->follow_up_date }}</td>
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