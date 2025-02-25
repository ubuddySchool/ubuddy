@extends('layouts.apphome')

@section('content')
 <!-- Success message from session -->
 @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}', 'Success', {
                closeButton: true,
                progressBar: true
            });
        </script>
    @endif
<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Enquiry List</h3>
                        </div>
                        <div class="col-auto text-end float-end ms-auto download-grp">
                           
                            <a href="{{route('enquiry.add')}}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i>New Enquiry</a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table
                        class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                        <thead class="student-thread">
                            <tr>
                                <th>ID</th>
                                <th>School Name</th>
                                <th>City</th>
                                <th>Last Visit Date</th>
                                <th>Follow Up Date</th>
                                <th>Status</th>
                                <th class="text-end">More</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($enquiries as $enquiry)
                                <tr>
                                    <td>{{ $enquiry->id }}</td>
                                    <td>{{ $enquiry->school_name }}</td>
                                    <td>{{ $enquiry->city }}</td>
                                    <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>

                                    <td>{{ $enquiry->status }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('enquiry.edit', $enquiry->id) }}" class="btn btn-sm bg-warning-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                        
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

@endsection
