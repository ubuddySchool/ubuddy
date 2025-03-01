@extends('layouts.apphome')

@section('content')


@if (session('success'))
<script>
    toastr.success('{{ session('
        success ') }}', 'Success', {
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

                            <a href="{{ route('follow_up') }}" class="bg-green-500 text-white p-2 rounded mb-2 sm:mb-0">Follow up</a>
                            <a href="{{ route('enquiry.add') }}" class="bg-indigo-500 text-white p-2 rounded mb-2 sm:mb-0"><i class="fas fa-plus me-2"></i>New
                                Enquiry</a>
                        </div>
                    </div>
                </div>
                
                <div class="container-fluid mx-auto px-4 sm:px-6 md:px-8 my-3">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <input type="text" placeholder="Search by pin code, school name" class="p-2 border rounded w-full">
        <select class="p-2 border rounded w-full">
            <option>City</option>
        </select>
        <select class="p-2 border rounded w-full">
            <option>Status</option>
        </select>
        <select class="p-2 border rounded w-full">
            <option>Current Flow</option>
        </select>
    </div>
</div>


                <div class="response">
                <table class="table table-bordered data-table">
                        <thead class="student-thread">
                            <tr>
                                <th>S No.</th>
                                <th>School Name</th>
                                <th>City</th>
                                <th>Last Visit</th>
                                <th>Follow Up</th>
                                <th>Status</th>
                                <th class="text-end">More</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enquiries as $enquiry)
                            <tr>
                                <td>{{ $enquiry->id }}</td>
                                <td>{{ $enquiry->school_name }}</td>
                                <td>{{ $enquiry->city }}</td>
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
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            More
                                        </button>
                                        <ul class="dropdown-menu ">
                                          
                                            <li> <a href="{{ route('enquiry.edit', $enquiry->id) }}"
                                                    class="dropdown-item btn btn-sm">
                                                    Edit
                                                </a></li>
                                            <li><a href="#" class="btn btn-sm m-r-10 dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#full-width-modal{{ $enquiry->id }}">
                                                    Add Visit
                                                </a></li>
                                            <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-modal{{ $enquiry->id }}">View</a></li>
                                            <!-- <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#update-flow-modal{{ $enquiry->id }}">Update Flow</a></li>
                                            <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#update-status-modal{{ $enquiry->id }}">Update Status</a></li> -->
                                            <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#update-follow-up-modal{{ $enquiry->id }}">Update follow-up date</a></li>
                                        </ul>
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

@include('user.modal')


<script type="text/javascript">
  $(function () {
        
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('home') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
        
  });
</script>
@endsection