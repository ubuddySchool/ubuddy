@extends('layouts.apphome')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Enquiry Details</h2>

    <div class="row">
        <!-- Left Column -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">School Information</h5>
                    <p><strong>School Name:</strong> {{ $enquiry->school_name }}</p>
                    <p><strong>Board:</strong> {{ $enquiry->board }}</p>
                    <p><strong>Address:</strong> {{ $enquiry->address }}</p>
                    <p><strong>Pin code:</strong> {{ $enquiry->pincode }}</p>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Additional Information</h5>
                    <p><strong>City:</strong> {{ $enquiry->city }}</p>
                    <p><strong>State:</strong> {{ $enquiry->state }}</p>
                    <p><strong>Website:</strong> <a href="{{ $enquiry->website }}" target="_blank" class="text-decoration-none">{{ $enquiry->website }}</a></p>
                    <p><strong>Last Visit Date:</strong> {{ $enquiry->created_at->format('Y-m-d') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button (Optional) -->
    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="btn btn-primary">Back to Enquiries</a>
    </div>
</div>
@endsection
