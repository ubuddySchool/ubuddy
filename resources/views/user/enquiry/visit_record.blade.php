@extends('layouts.apphome')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

                <div class="page-header">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-12 col-md-5 mb-3 mb-md-0">
                            <h3 class="page-title">Visit List</h3>
                        </div>

                        <div class="col-12 col-md-auto mb-3 mb-md-0">
                            <form method="GET" action="{{ route('visit_record') }}">
                                <div class="d-flex flex-column flex-md-row align-items-center gap-3 gap-md-2 justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <label for="from_date" class="form-label mb-0  me-1">From:</label>
                                        <input type="date" id="from_date" name="from_date" class="form-control form-control-sm"
                                            value="{{ request('from_date') }}">
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label for="to_date" class="form-label mb-0 me-1">To:</label>
                                        <input type="date" id="to_date" name="to_date" class="form-control form-control-sm"
                                            value="{{ request('to_date') }}">
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <!-- <label for="visit_type" class="form-label mb-0">Visit Type:</label> -->
                                        <select id="visit_type" name="visit_type" class="form-control form-control-sm">
                                            <option value="">Visit type</option>
                                            <option value="New Meeting" {{ request('visit_type') == 'New Meeting' ? 'selected' : '' }}>New Meeting</option>
                                            <option value="Follow-up" {{ request('visit_type') == 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
                                        </select>
                                    </div>
                                    <!-- <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-info btn-sm">Filter</button>
                                    </div> -->
                                </div>
                            </form>
                        </div>

                        <!-- Today's / All Time Filter -->
                        <div class="col-12 col-md-auto mb-3 mb-md-0">
                            <form method="GET" action="{{ route('visit_record') }}">
                                    <input type="checkbox"
                                            id="expiry_filter_switch"
                                            class="form-check-input"
                                            name="today_visit"
                                            value="today"
                                            onchange="this.form.submit()"
                                            {{ request('today_visit') == 'showall' ? 'checked' : '' }}>
                                    <label for="expiry_filter_switch" class="form-label mb-0">Show All</label>
                            </form>
                        </div>
                        <!-- <div class="col-12 col-md-auto mb-3 mb-md-0">
                            <form method="GET" action="{{ route('visit_record') }}">
                                <div class="d-flex align-items-center gap-2 justify-content-center">
                                    <label for="expiry_filter_switch" class="form-label mb-0">All Time</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox"
                                            id="expiry_filter_switch"
                                            class="form-check-input"
                                            name="today_visit"
                                            value="today"
                                            onchange="this.form.submit()"
                                            {{ request('today_visit') == 'today' ? 'checked' : '' }}>
                                    </div>
                                    <label for="expiry_filter_switch" class="form-label mb-0">Today's</label>
                                </div>
                            </form>
                        </div> -->

                        <!-- Back Button Section -->
                        <div class="col-12 col-md-auto mb-3 mb-md-0">
                            <a href="{{ route('home') }}" class="btn btn-primary btn-sm w-100 w-md-auto">Back</a>
                        </div>

                        <div class="col-12 col-md-auto text-center text-md-end">
                            <button class="btn btn-primary my-3" disabled>
                                Visit counter:
                                {{ $enquiries->sum(fn($enquiry) => $enquiry->visits->count() ?? 0) }}
                            </button>
                        </div>

                    </div>
                    <div class="response mt-3">
                        <table class="table border-0 star-student table-hover table-center mb-0 datatable table-responsive table-striped" id="enquiry-table">
                            <thead class="student-thread">
                                <tr>
                                    <th>S No.</th>
                                    <th>School Name</th>
                                    <th>Visit Date</th>
                                    <th>Visit Type</th>
                                    <th>Meeting Type</th>
                                    <th>View Details</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @php $rowNumber = 1; @endphp

                                @if ($enquiries->isEmpty() || $enquiries->every(fn($enquiry) => $enquiry->visits->isEmpty()))
                                <tr>
                                    <td colspan="4" class="text-center">No data available</td>
                                </tr>
                                @else
                                @foreach ($enquiries as $enquiry)
                                @foreach ($enquiry->visits as $visit)
                                    <tr>
                                        <td>{{ $rowNumber++ }}</td>
                                        <td>{{ $enquiry->school_name ?? 'No School Name' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($visit->date_of_visit)->format('d-m-Y') }}</td>
                                        <td>
                                            @if ($visit->contact_method == 1)
                                                In Person Meeting
                                            @elseif ($visit->contact_method == 0)
                                               Telephonic
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if ($visit->visit_type == 1)
                                                New Meeting
                                            @elseif ($visit->visit_type == 0)
                                                Follow-up
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    <td> 
                                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view-modal{{ $enquiry->id  }}">
                                        View Details
                                    </a>
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

@endsection
