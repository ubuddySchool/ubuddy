@extends('layouts.apphome')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="content container-fluid mt-1">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">


                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col align-items-center">
                            <a href="{{ route('admin.home') }}" class="text-decoration-none text-dark me-2 backButton"> <i class="fas fa-arrow-left"></i></a>
                            <h3 class="page-title">Visit List</h3>
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
                                    <p><strong>Board:</strong>
                                        @if($enquiry->board == 'MP Board')
                                        {{ $enquiry->board }}
                                        @else
                                        {{ $enquiry->other_board_name }}
                                        @endif
                                    </p>

                                </div>

                                <div id="additional-details{{ $enquiry->id }}" style="display: none;">
                                    <div class="row">
                                        <div class="col-12 col-md-6">


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
                                            <p><strong>Student No.:</strong> {{ $enquiry->students_count }}</p>
                                            <p><strong>Enquiry create Date:</strong> {{ $enquiry->created_at->format('d-m-y') }}</p>
                                            <p><strong>Enquiry Remarks:</strong> {{ $enquiry->remarks }}</p>

                                            @php
                                            $images = json_decode($enquiry->images ?? '[]');
                                            @endphp
                                            @if(!empty($images))
                                            <p><strong>Images:</strong>
                                                @foreach($images as $index => $imagePath)
                                            <div class="position-relative" style="display:inline-block;">
                                                <img src="{{ asset($imagePath) }}" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                            </div>
                                            @endforeach
                                            </p>
                                            @endif



                                        </div>

                                        <div class="col-12 col-md-6">
                                            <p><strong>Address:</strong> {{ $enquiry->address }}</p>
                                            <p><strong>Town:</strong> {{ $enquiry->town }}</p>
                                            <p><strong>City:</strong> {{ $enquiry->city }}</p>
                                            <p><strong>State:</strong> {{ $enquiry->state }}</p>
                                            <p><strong>Pin code:</strong> {{ $enquiry->pincode }}</p>
                                            <p><strong>Interested in software:</strong>
                                                @if($enquiry->interest_software == 1)
                                                <span class="badge bg-primary">Interested</span>
                                                @elseif($enquiry->interest_software == 0)
                                                <span class="badge bg-secondary">Not Interested</span>
                                                @elseif($enquiry->interest_software == 2)
                                                <span class="badge bg-success">Highly Interested</span>
                                                @endif
                                            </p>


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
                                                <th>S.No.</th>
                                                <th>Visit Date</th>
                                                <th>POC</th>
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