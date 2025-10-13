@php
    $user = auth()->user();
@endphp
@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-section pt-120">
        <div class="container">
            <div class="dashboard-wrapper">
                @include('Template::components.user.top_header')
                <div class="dashboard-cards mb-4">
                    <h3 class="dashboard-title fs--18 fw--600 mb-4">{{__($pageTitle)}}</h3>
                    <div class="row g-4">
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
                            <a href="#" class="dashboard-card position-relative d-flex gap--20 align-items-center">
                                <div class="dashboard-card__image">
                                    <img src="{{getImage(getFilePath('shape').'dashboard-shape.png')}}" alt="@lang('dashboard-shape')">
                                </div>
                                <div class="dashboard-icon">
                                    <span>
                                        <i class="fa-solid fa-book"></i>
                                    </span>
                                </div>
                                <div class="dashboard-content">
                                    <p class="dashboard-card__title fs--16 fw--600">@lang('Current Balance')</p>
                                    <h3 class="dashboard-card__mouny fs--24 fw--600 m-0">{{$general->cur_sym.showAmount($user->balance)}}</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
                            <a href="#" class="dashboard-card position-relative d-flex gap--20 align-items-center">
                                <div class="dashboard-card__image">
                                          <img src="{{getImage(getFilePath('shape').'dashboard-shape.png')}}" alt="@lang('dashboard-shape')">
                                </div>
                                <div class="dashboard-icon">
                                    <span><i class="fas fa-coins"></i>
                                    </span>
                                </div>
                                <div class="dashboard-content">
                                    <p class="dashboard-card__title fs--16 fw--600">Total Earnings</p>
                                    <h3 class="dashboard-card__mouny fs--24 fw--600 m-0">$458</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
                            <a href="#" class="dashboard-card position-relative d-flex gap--20 align-items-center">
                                <div class="dashboard-card__image">
                                          <img src="{{getImage(getFilePath('shape').'dashboard-shape.png')}}" alt="@lang('dashboard-shape')">
                                </div>
                                <div class="dashboard-icon">
                                    <span><i class="fas fa-clipboard-list"></i>
                                    </span>
                                </div>
                                <div class="dashboard-content">
                                    <p class="dashboard-card__title fs--16 fw--600">Total Surveys Taken</p>
                                    <h3 class="dashboard-card__mouny fs--24 fw--600 m-0">$558</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
                            <a href="#" class="dashboard-card position-relative d-flex gap--20 align-items-center">
                                <div class="dashboard-card__image">
                                    <img src="{{getImage(getFilePath('shape').'dashboard-shape.png')}}" alt="@lang('dashboard-shape')">
                                </div>
                                <div class="dashboard-icon">
                                    <span><i class="fas fa-check-square"></i>
                                    </span>
                                </div>
                                <div class="dashboard-content">
                                    <p class="dashboard-card__title fs--16 fw--600">Active Survey</p>
                                    <h3 class="dashboard-card__mouny fs--24 fw--600 m-0">452</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="dashboard-table card">
                    <h3 class="dashboard-table__title fs--16 fw--700 mb--16">Survey Activity</h3>
                    <div class="dashboard-table__items">
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>Survey Title</th>
                                    <th>Category</th>
                                    <th>Duration</th>
                                    <th>Rewards</th>
                                    <th>Date Taken</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Details">
                                        <div class="table__pt">
                                            Your Daily Shopping Habits
                                        </div>
                                    </td>
                                    <td data-label="File Type">Education</td>
                                    <td data-label="Date">10 min</td>
                                    <td data-label="Date">$20</td>
                                    <td data-label="Date">15may, 2025</td>
                                    <td data-label="Date"><span class="badge badge--success">Completed</span></td>
                                    <td data-label="Date">
                                        <div class="dropdown">
                                            <button class="dashboard-table__btn" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Details">
                                        <div class="table__pt">
                                            Your Daily Shopping Habits
                                        </div>
                                    </td>
                                    <td data-label="File Type">Education</td>
                                    <td data-label="Date">10 min</td>
                                    <td data-label="Date">$20</td>
                                    <td data-label="Date">15may, 2025</td>
                                    <td data-label="Date"><span class="badge badge--success">Completed</span></td>
                                    <td data-label="Date">
                                        <div class="dropdown">
                                            <button class="dashboard-table__btn" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Details">
                                        <div class="table__pt">
                                            Your Daily Shopping Habits
                                        </div>
                                    </td>
                                    <td data-label="File Type">Education</td>
                                    <td data-label="Date">10 min</td>
                                    <td data-label="Date">$20</td>
                                    <td data-label="Date">15may, 2025</td>
                                    <td data-label="Date"><span class="badge badge--success">Completed</span></td>
                                    <td data-label="Date">
                                        <div class="dropdown">
                                            <button class="dashboard-table__btn" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Details">
                                        <div class="table__pt">
                                            Your Daily Shopping Habits
                                        </div>
                                    </td>
                                    <td data-label="File Type">Education</td>
                                    <td data-label="Date">10 min</td>
                                    <td data-label="Date">$20</td>
                                    <td data-label="Date">15may, 2025</td>
                                    <td data-label="Date"><span class="badge badge--success">Completed</span></td>
                                    <td data-label="Date">
                                        <div class="dropdown">
                                            <button class="dashboard-table__btn" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            </ul>
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
