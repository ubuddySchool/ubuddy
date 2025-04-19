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
                    <a href="{{ route('admin.home') }}" class="btn btn-primary float-end btn-sm">Back</a>
                    <div class="row align-items-center">
                        <div class="col-12 col-md">
                            <h3 class="page-title">Expired Follow up List</h3>
                        </div>
                        <div class="col-12 col-md-auto text-end ms-auto download-grp">
                            <form method="GET" action="{{ route('admin.expired_follow_up') }}">
                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                    <label for="from_date" class="form-label mb-0">From:</label>
                                    <input type="date" id="from_date" name="from_date" class="form-control form-control-sm"
                                        value="{{ request('from_date') }}">

                                    <label for="to_date" class="form-label mb-0">To:</label>
                                    <input type="date" id="to_date" name="to_date" class="form-control form-control-sm"
                                        value="{{ request('to_date') }}">

                                        <!-- <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-info btn-sm">Filter</button>
                                            <a href="{{ route('expired_follow_up') }}" class="btn btn-secondary btn-sm">Reset</a>
                                        </div> -->
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
                                    <th>Expiry Date</th>
                                    <th class="w-10">Remarks</th>
                                </tr>
                            </thead>
                            <!-- Display Table -->
                            <tbody id="table-body">
                                @if($noDataFound)
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No Data Found</td>
                                </tr>
                                @else
                                @foreach ($enquiries as $enquiry)
                                @foreach ($enquiry->visits as $visit)
                                <tr>
                                    <td>{{ $loop->parent->index + 1 }}</td>
                                    <td>{{ $enquiry->school_name ?? 'No School Name' }}</td>
                                    <td>{{ $visit->follow_up_date }}</td>
                                    <td>
                                        @if(empty($visit->expired_remarks))
                                        <a href="#" class="dropdown-item btn btn-sm btn-primary"
                                            style="background-color: #4040ff;color:white;"
                                            data-bs-toggle="modal" data-bs-target="#add-remark-modal{{ $visit->id }}">
                                            Add Remark
                                        </a>
                                        @else
                                        <span>{{ $visit->expired_remarks }}</span>
                                        @endif
                                    </td>
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