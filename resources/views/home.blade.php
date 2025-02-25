@extends('layouts.apphome')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}


{{-- <div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Enquiry List</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ul>
        </div>
    </div>
</div> --}}

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
                            <a href="#" class="btn btn-outline-primary me-2"><i
                                    class="fas fa-download"></i> Download</a>
                            <a href="add-time-table.html" class="btn btn-primary"><i
                                    class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table
                        class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                        <thead class="student-thread">
                            <tr>
                                <th>ID</th>
                                <th>School Name</th>
                                <th>City</th>
                                <th>Last Visit Date</th>
                                <th>Follow Up Date</th>
                                <th>Status</th>
                                {{-- <th>Date</th> --}}
                                <th class="text-end">More</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="">
                                    <div class=" nav-item dropdown has-arrow new-user-menus">
                                        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">More</a>
                                        <div class="dropdown-menu">
                                            <a href="javascript:;" class="dropdown-item btn btn-sm bg-success-light me-2">
                                                <i class="feather-eye"></i>
                                            </a>
                                            <a href="edit-time-table.html"
                                                class="btn btn-sm bg-danger-light dropdown-item">
                                                <i class="feather-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                    {{-- <li class="nav-item dropdown has-arrow new-user-menus">
                                        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                                            <span class="user-img">
                                            <img class="rounded-circle" src="{{ asset('assets/img/profiles/avatar-01.jpg') }}" width="31" alt="Ryan Taylor">
                                            <div class="user-text">
                                                @if(Auth::check())
                                                    <div class="user-text">
                                                        <h6>{{ Auth::user()->name }}</h6>
                                                        <p class="text-muted text-capitalize mb-0">{{ Auth::user()->type }}</p>
                                                    </div>
                                                @endif
                                                    
                                                   
                                                </div>
                                            </span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                    
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>

                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div> --}}
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>PRE2309</td>
                                {{-- <td>
                                    <h2 class="table-avatar">
                                        <a class="avatar avatar-sm me-2"><img
                                                class="avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-01.jpg"
                                                alt="User Image"></a>
                                        <a>Aaliyah</a>
                                    </h2>
                                </td> --}}
                                <td>10</td>
                                <td>English</td>
                                <td>10:00 AM</td>
                                <td>01:00 PM</td>
                                <td>23 Apr 2020</td>
                                <td class="text-end">
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="edit-time-table.html"
                                            class="btn btn-sm bg-danger-light">
                                            <i class="feather-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
