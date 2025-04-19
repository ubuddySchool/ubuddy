@extends('layouts.apphome')

@section('content')
<style>
    .select2 {
        width: auto !important;
    }
    .select2-container--open {
        z-index: 1088 !important; /* Higher than Bootstrap modal (default 1050) */
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

                <div class="page-header">

                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <h3 class="page-title">CRM List</h3>
                        </div>
                        <div class="col-12 col-md-6 float-end text-end">
                            <select class="p-2 border rounded select2" id="visit_type">
                                <option value="">Select City</option>
                                @foreach($enquiries as $index => $enquiry)
                                <option value="">{{ $enquiry->city ?? 'Not Mention city' }}</option>
                                @endforeach
                            </select>


                            <select class="p-2 border rounded select2" id="visit_type_1">
                                <option value="">Select CRM</option>
                                @foreach($enquiries as $index => $enquiry)
                                <option value="">{{ $enquiry->user->name ?? 'Not Assigned' }}</option>
                                @endforeach
                            </select>
                            @if (!$noDataFound)
                            <!-- <div id="info-container " class="mb-2"> -->
                            <button class="btn btn-info btn-sm" id="info-btn" disabled>Total Records: {{ $totalCount }}</button>
                            <a href="{{ route('admin.home') }}" class="btn btn-primary btn-sm">Back</a>
                            <!-- </div> -->
                            @endif

                        </div>
                    </div>
                    <div class="response mt-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>S No.</th>
                                    <th>School Name</th>
                                    <th>City</th>
                                    <th>CRM Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enquiries as $index => $enquiry)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $enquiry->school_name }}</td>
                                    <td>{{ $enquiry->city ?? 'Not Mention city' }}</td>
                                    <td>{{ $enquiry->user->name ?? 'Not Assigned' }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#changeCrmModal{{ $enquiry->id }}">
                                            Change
                                        </button>

                                            <div class="modal fade" id="changeCrmModal{{ $enquiry->id }}" tabindex="-1" aria-labelledby="changeCrmLabel{{ $enquiry->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="changeCrmLabel{{ $enquiry->id }}">Change CRM for {{ $enquiry->school_name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <select name="crm_id" class="form-select select2" required>
                                                                <option class="indexing" value="">Select CRM</option>
                                                                @foreach($users as $user)
                                                                <option class="indexing" value="{{ $user->id }}" {{ ($enquiry->crm_id == $user->id) ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
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
</div>


<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Select an option',
            allowClear: true,
            width: 'resolve' 
        });
    });

    $('.select2').select2({
        width: '100%'
    });
    $(document).on('shown.bs.modal', '.modal', function () {
        $(this).find('.select2:not(.select2-hidden-accessible)').select2({
            dropdownParent: $(this),
            width: '100%'
        });
    });

</script>

@endsection