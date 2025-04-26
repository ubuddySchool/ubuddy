@extends('layouts.apphome')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">

                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col align-items-center">
                                <a href="{{ route('admin.home') }}" class="text-decoration-none text-dark me-2 backButton">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <h3 class="page-title">Expired Follow up List</h3>
                            </div>
                        </div>
                    </div>

                <div class="page-header">
                    <div class="row align-items-center">
                        
                        <div class="col-12 col-md-auto  ms-auto download-grp">
                            <form id="filterForm">
                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                    <label for="from_date" class="form-label mb-0">From:</label>
                                    <input type="date" id="from_date" name="from_date" class="form-control form-control-sm"
                                        value="{{ request('from_date') }}">

                                    <label for="to_date" class="form-label mb-0">To:</label>
                                    <input type="date" id="to_date" name="to_date" class="form-control form-control-sm"
                                        value="{{ request('to_date') }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                
                <div class="response mt-3">
                    <table class="table border-0 star-student table-hover table-center mb-0 datatable table-responsive table-striped" id="enquiry-table">
                        <thead class="student-thread">
                            <tr>
                                <th>S No.</th>
                                <th>School Name</th>
                                <th>Expiry Date</th>
                                <th class="w-10">Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @if($noDataFound)
                            <tr>
                                <td colspan="4" class="text-center text-muted">No Data Found</td>
                            </tr>
                            @else
                            @php
                            $serialnum = 1 
                            @endphp
                            @foreach ($enquiries as $enquiry)
                            @foreach ($enquiry->visits as $visit)
                            <tr>
                                <td>{{ $serialnum++ }}</td>
                                <td>{{ $enquiry->school_name ?? 'No School Name' }}</td>
                                <td>{{ $visit->follow_up_date }}</td>
                                <td>
                                    @if(empty($visit->expired_remarks))
                                    N/A
                                    @else
                                    <span>{{ $visit->expired_remarks }}</span>
                                    @endif
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

@include('user.modal')

<script>
    $(document).ready(function () {
        $('#from_date, #to_date').on('change', function () {
            loadFilteredData();
        });

        function loadFilteredData() {
          
            const fromDate = $('#from_date').val();
            const toDate = $('#to_date').val();

            let dateFilter = {};

            if (fromDate && toDate) {
                dateFilter = {
                    from_date: fromDate,
                    to_date: toDate
                };
            } 
            else if (fromDate) {
                dateFilter = {
                    from_date: fromDate
                };
            }
            else if (toDate) {
                dateFilter = {
                    to_date: toDate
                };
            }

            $.ajax({
                url: "{{ route('admin.expired_follow_up') }}", 
                type: "GET",
                data: dateFilter, 
                success: function (response) {
                    let tableBody = $('#table-body');
                    tableBody.empty();

                    if (response.noDataFound) {
                        tableBody.append('<tr><td colspan="4" class="text-center text-muted">No Data Found</td></tr>');
                    } else {
                        let index = 1;
                        response.enquiries.forEach(enquiry => {
                            enquiry.visits.forEach(visit => {
                                let row = `
                                    <tr>
                                        <td>${index++}</td>
                                        <td>${enquiry.school_name || 'No School Name'}</td>
                                        <td>${visit.follow_up_date}</td>
                                        <td>${visit.expired_remarks || 'N/A'}</td>
                                    </tr>
                                `;
                                tableBody.append(row);
                            });
                        });
                    }
                },
                error: function () {
                    toastr.error("Error loading data.");
                }
            });
        }
    });
</script>
@endsection
