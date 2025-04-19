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
                    
                    <div class="row align-items-center">
                        <div class="col-12 col-md-9">
                            <h3 class="page-title">CRM List</h3>
                        </div>
                        <div class="col-12 col-md-3 float-end text-end">
                        @if (!$noDataFound)
                        <!-- <div id="info-container " class="mb-2"> -->
                            <button class="btn btn-info btn-sm" id="info-btn" disabled>Total Records: {{ $totalCount }}</button>
                            <a href="{{ route('admin.assin.crm') }}" class="btn btn-danger btn-sm bg-red-500 text-white rounded  sm:mb-0  ">Assign school</a>

                            <a href="{{ route('admin.home') }}" class="btn btn-primary btn-sm">Back</a>
                        <!-- </div> -->
                        @endif

                    </div>
                    </div>

                    <div class="response mt-3">
                        <table class="table border-0 star-student table-hover table-center mb-0 datatable table-responsive table-striped" id="enquiry-table">
                            <thead class="student-thread">
                                <tr>
                                    <th>S. No.</th>
                                    <th>CRM</th>
                                    <th>Gender</th>
                                    <th>D.O.B.</th>
                                    <th>Contact Number</th>
                                    <th>City</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @if($noDataFound)
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No Data Found</td>
                                </tr>
                                @else
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $user->name ?? 'N/A' }}</td>
                                    <td>Male</td>
                                    <td>{{ $user->created_at ? $user->created_at->format('d-m-Y') : 'N/A' }}</td>
                                    <td>9876543219</td>
                                    <td>Indore</td>
                                </tr>
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


@endsection