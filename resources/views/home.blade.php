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

                                <a href="{{ route('enquiry.add') }}" class="btn btn-primary"><i class="fas fa-plus"></i>New
                                    Enquiry</a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
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
                                @foreach ($enquiries as $enquiry)
                                    <tr>
                                        <td>{{ $enquiry->id }}</td>
                                        <td>{{ $enquiry->school_name }}</td>
                                        <td>{{ $enquiry->city }}</td>
                                        <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>

                                        <td>{{ $enquiry->status }}</td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-primary text-white m-r-10"
                                                data-bs-toggle="modal" data-bs-target="#full-width-modal{{ $enquiry->id }}">
                                                Add Visit
                                            </a>
                                            <a href="{{ route('enquiry.edit', $enquiry->id) }}"
                                                class="btn btn-sm bg-warning-light">
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
    @foreach ($enquiries as $enquiry)
        <div id="full-width-modal{{ $enquiry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">                    
                    <div class="modal-header">
                        <h4 class="modal-title" id="fullWidthModalLabel">Add Visit</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="px-3" action="#">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 form-group local-forms">
                                    <label>Date Of Visit <span class="login-danger">*</span></label>
                                    <input class="form-control" type="date" placeholder="DD-MM-YYYY">
                                </div>
                                <div class="col-md-6 form-group local-forms">
                                    <label>Time Of Visit <span class="login-danger">*</span></label>
                                    <input class="form-control" type="time">
                                </div>
                                <div class="col-md-6 form-group local-forms">
                                    <label for="username" class="form-label">Visit Remark</label>
                                    <input class="form-control" type="text" id="username" required placeholder="Visit Remark">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach    
@endsection
