@extends('layouts.apphome')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

                <div class="page-header">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-12 col-md-5 mb-3 mb-md-0">
                            <h3 class="page-title">Visit List</h3>
                        </div>


                        <div class="col-12 col-md-auto mb-3 mb-md-0">

                        </div>


                        <!-- Back Button Section -->
                        <div class="col-12 col-md-auto mb-3 mb-md-0">
                            <a href="{{ route('home') }}" class="btn btn-primary btn-sm w-100 w-md-auto">Back</a>
                        </div>





                    </div>
                </div>
                <div class="page-header">
                    <div class="row align-items-center justify-content-between">

                        <div class="col-12 col-md-12 ">

                            @foreach ($enquiries as $enquiry)





                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <p><strong>School Name:</strong> {{ $enquiry->school_name }}</p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p><strong>City:</strong> {{ $enquiry->city }}</p>
                                </div>

                                <div id="additional-details{{ $enquiry->id }}" style="display: none;">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <p><strong>Board:</strong>
                                                @if($enquiry->board == 'MP Board')
                                                {{ $enquiry->board }}
                                                @else
                                                {{ $enquiry->other_board_name }}
                                                @endif
                                            </p>
                                            <p><strong>Address:</strong> {{ $enquiry->address }}</p>
                                            <p><strong>Website:</strong>
                                                @if($enquiry->website == 'yes')
                                                <a href="{{ $enquiry->website_url }}" target="_blank" class="text-decoration-none">{{ $enquiry->website_url }}</a>
                                                @elseif($enquiry->website == 'not_know')
                                                <span class="badge bg-danger">Not know</span>
                                                @else
                                                <span class="badge bg-danger">No</span>
                                                @endif

                                            </p>
                                            <p><strong>Software :</strong>
                                                @if($enquiry->current_software == 1)
                                                {{ $enquiry->software_details }}
                                                @elseif($enquiry->current_software == 0 )
                                                <span class="badge bg-danger">No</span>
                                                @elseif($enquiry->current_software == 2 )
                                                <span class="badge bg-danger">Not know</span>
                                                @endif
                                            </p>


                                        </div>

                                        <div class="col-12 col-md-6">

                                            <p><strong>State:</strong> {{ $enquiry->state }}</p>
                                            <p><strong>Enquiry create Date:</strong> {{ $enquiry->created_at->format('d-m-y') }}</p>
                                            <p><strong>Enquiry Remarks:</strong> {{ $enquiry->remarks }}</p>
                                            <p><strong>Pin code:</strong> {{ $enquiry->pincode }}</p>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <button class="btn btn-outline-primary btn-sm mx-auto d-block" onclick="toggleDetails({{ $enquiry->id }})" id="show-more-btn{{ $enquiry->id }}">View More</button>



                            <!-- New Table Below -->
                            <div class="mt-4">
                                <div class="table-responsive">
                                    <table class="table table-striped table-primary table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Visit Date</th>
                                                <th>Poc</th>
                                                <th>Remark</th>
                                                <th>Contact Method</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $visits = \App\Models\Visit::where('enquiry_id', $enquiry->id)->get();
                                            @endphp
                                            @if ($visits->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center">No data found</td>
                                            </tr>
                                            @else
                                            @foreach ($visits as $index => $visit)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($visit->date_of_visit)->format('d-m-Y') }}</td>

                                                <!-- Accessing poc_name using the relationship -->
                                                <!-- <td>{{ $visit->poc->poc_name ?? 'No Name' }}</td> -->
                                                <td>
                                                    @php
                                                    $pocNames = \App\Models\Poc::whereIn('id', $visit->poc_ids)->pluck('poc_name')->toArray();
                                                    @endphp
                                                    {{ implode(', ', $pocNames) ?: 'No Name' }}
                                                </td>

                                                <td>{{ $visit->visit_remarks }}</td>
                                                <td>
                                                    @if ($visit->contact_method == 0)
                                                    Telephonic
                                                    @elseif ($visit->contact_method == 1)
                                                    In-Person Meeting
                                                    @endif
                                                </td>

                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>





                            @endforeach

                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
</div>


@include('user.modal')

@endsection