@extends('layouts.apphome')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

                <div class="page-header">
                    <div class="row align-items-center justify-content-between">
                        <!-- Page Title Section (always on top) -->
                        <div class="col-12 col-md-5 mb-3 mb-md-0">
                            <h3 class="page-title">Visit List</h3>
                        </div>

                        <!-- Filter Section (From/To Date & Buttons) -->
                        <div class="col-12 col-md-auto mb-3 mb-md-0">
                            <form method="GET" action="{{ route('visit_record') }}">
                                <div class="d-flex flex-column flex-md-row align-items-center gap-3 gap-md-2 justify-content-between">
                                    <!-- From Date -->
                                    <div class="d-flex">
                                        <label for="from_date" class="form-label mb-0">From:</label>
                                        <input type="date" id="from_date" name="from_date" class="form-control form-control-sm"
                                            value="{{ request('from_date') }}">
                                    </div>

                                    <!-- To Date -->
                                    <div class="d-flex ">
                                        <label for="to_date" class="form-label mb-0">To:</label>
                                        <input type="date" id="to_date" name="to_date" class="form-control form-control-sm"
                                            value="{{ request('to_date') }}">
                                    </div>

                                    <!-- Filter and Reset Buttons -->
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                        <a href="{{ route('follow_up') }}" class="btn btn-secondary btn-sm ">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Today's / All Time Filter -->
                        <div class="col-12 col-md-auto mb-3 mb-md-0">
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
                        </div>

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
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @php $rowNumber = 1; @endphp

                                @if ($enquiries->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">No data available</td>
                                </tr>
                                @else
                                @foreach ($enquiries as $enquiry)
                                @php
                                $sortedVisits = $enquiry->visits->sortBy('date_of_visit');
                                $isFirstVisit = true;
                                @endphp

                                @if ($sortedVisits->isEmpty())
                                <tr>
                                    <td>{{ $rowNumber++ }}</td>
                                    <td>{{ $enquiry->school_name ?? 'No School Name' }}</td>
                                    <td colspan="2" class="text-center">No visits available</td>
                                </tr>
                                @else
                                @foreach ($sortedVisits as $visit)
                                <tr>
                                    <td>{{ $rowNumber++ }}</td>
                                    <td>{{ $enquiry->school_name ?? 'No School Name' }}</td>
                                    <td>{{ $visit->date_of_visit }}</td>
                                    <td>{{ $isFirstVisit ? 'New Meeting' : 'Follow-up' }}</td>
                                </tr>
                                @php $isFirstVisit = false; @endphp
                                @endforeach
                                @endif
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