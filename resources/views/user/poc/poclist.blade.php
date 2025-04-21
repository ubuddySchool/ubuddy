@extends('layouts.apphome')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

            

                <!-- Page Header -->
                <div class="page-header mb-4">
                    <div class="row ">
                        <div class="col-12 col-md-12 d-flex align-items-center mb-2">
                            <a href="{{ route('home') }}" class="text-decoration-none text-dark me-2 backButton">  <i class="fas fa-arrow-left"></i></a>
                            <h3 class="page-title">POC List</h3>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <form action="{{ route('add.pocs', $id) }}" method="POST" class="p-4 shadow-sm border rounded bg-light">

                                @csrf
                                <div class="row">
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="poc_name" class="form-label">POC Name</label>
                                        <input type="text" name="poc_name" class="form-control" placeholder="POC Name" required>
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="poc_designation" class="form-label">POC Designation</label>
                                        <input type="text" name="poc_designation" class="form-control" placeholder="POC Designation" required>
                                    </div>
                                    <div class="col-md-4 col-12 mb-3">
                                        <label for="poc_number" class="form-label">POC Number</label>
                                        <input type="text" name="poc_number" class="form-control" placeholder="POC Contact Number" maxlength="10" id="poc_number" required pattern="^\d{10}$" title="Please enter a 10-digit phone number" oninput="validateNumberInput(event)" />
                                    </div>
                                </div>
                                <div class="d-grid mt-3 ">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->




                <!-- Table Section -->
                <div class="table-responsive">
                    <table class="table table-hover table-center table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>S No.</th>
                                <th>POC Name</th>
                                <th>POC Designation</th>
                                <th>POC Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($pocs as $poc)
                            <tr>
                                <td>1</td>
                                <td>{{ $poc->poc_name }}</td>
                                <td>{{ $poc->poc_designation }}</td>
                                <td>{{ $poc->poc_number }}</td>
                                <td>
                                    <!-- Trigger Modal -->
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editPocModal{{ $poc->id }}">
                                        Edit
                                    </button>
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

@foreach ($pocs as $poc)
<!-- Edit Modal -->
<div class="modal fade" id="editPocModal{{ $poc->id }}" tabindex="-1" aria-labelledby="editPocModalLabel{{ $poc->id }}" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('update.poc', $poc->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editPocModalLabel{{ $poc->id }}">Edit POC</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>POC Name</label>
                        <input type="text" class="form-control" name="poc_name" value="{{ $poc->poc_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>POC Designation</label>
                        <input type="text" class="form-control" name="poc_designation" value="{{ $poc->poc_designation }}" required>
                    </div>
                    <div class="mb-3">
                        <label>POC Number</label>
                        <input type="text" class="form-control" name="poc_number" value="{{ $poc->poc_number }}" required maxlength="10" pattern="\d{10}" title="Enter a 10-digit number" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection