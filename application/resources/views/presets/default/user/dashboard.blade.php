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
                    <h3 class="dashboard-title fs--18 fw--600 mb-4">{{ __($pageTitle) }}</h3>
                    <div class="row  g-3 g-lg-4">
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
                            <a href="javascript:void(0)"
                                class="dashboard-card position-relative d-flex gap--20 align-items-center">
                                <div class="dashboard-card__image">
                                    <img src="{{ getImage(getFilePath('shape') . 'dashboard-shape.png') }}"
                                        alt="@lang('dashboard-shape')">
                                </div>
                                <div class="dashboard-icon">
                                    <span>
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                    </span>
                                </div>
                                <div class="dashboard-content">
                                    <p class="dashboard-card__title fs--16 fw--600">@lang('Current Balance')</p>
                                    <h3 class="dashboard-card__mouny fs--24 fw--600 m-0">
                                        {{ $general->cur_sym . showAmount($user->balance) }}</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
                            <a href="{{ route('user.credit.purchase') }}"
                                class="dashboard-card position-relative d-flex gap--20 align-items-center">
                                <div class="dashboard-card__image">
                                    <img src="{{ getImage(getFilePath('shape') . 'dashboard-shape.png') }}"
                                        alt="@lang('dashboard-shape')">
                                </div>
                                <div class="dashboard-icon">
                                    <span><i class="fas fa-coins"></i>
                                    </span>
                                </div>
                                <div class="dashboard-content">
                                    <p class="dashboard-card__title fs--16 fw--600">@lang('Total Credit')</p>
                                    <h3 class="dashboard-card__mouny fs--24 fw--600 m-0">{{ $user->credit }}</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
                            <a href="{{ route('user.survey.index') }}"
                                class="dashboard-card position-relative d-flex gap--20 align-items-center">
                                <div class="dashboard-card__image">
                                    <img src="{{ getImage(getFilePath('shape') . 'dashboard-shape.png') }}"
                                        alt="@lang('dashboard-shape')">
                                </div>
                                <div class="dashboard-icon">
                                    <span><i class="fas fa-clipboard-list"></i>
                                    </span>
                                </div>
                                <div class="dashboard-content">
                                    <p class="dashboard-card__title fs--16 fw--600">@lang('Total Surveys Taken')</p>
                                    <h3 class="dashboard-card__mouny fs--24 fw--600 m-0">{{ $widget['totalSurvey'] }}</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
                            <a href="{{ route('user.survey.submission') }}"
                                class="dashboard-card position-relative d-flex gap--20 align-items-center">
                                <div class="dashboard-card__image">
                                    <img src="{{ getImage(getFilePath('shape') . 'dashboard-shape.png') }}"
                                        alt="@lang('dashboard-shape')">
                                </div>
                                <div class="dashboard-icon">
                                    <span><i class="fas fa-check-square"></i>
                                    </span>
                                </div>
                                <div class="dashboard-content">
                                    <p class="dashboard-card__title fs--16 fw--600">@lang('Survey Submission')</p>
                                    <h3 class="dashboard-card__mouny fs--24 fw--600 m-0">{{ $widget['totalAnswer'] }}</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="dashboard-table card">
                    <h3 class="dashboard-table__title fs--16 fw--700 mb--16">@lang('Latest Transactions')</h3>
                    <div class="dashboard-table__items">
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('Trx')</th>
                                    <th class="text-center">@lang('Transacted')</th>
                                    <th class="text-center">@lang('Amount')</th>
                                    <th class="text-center">@lang('Post Balance')</th>
                                    <th>@lang('Detail')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trx)
                                    <tr>
                                        <td>{{ $trx->trx }}</td>

                                        <td class="text-center">
                                            {{ showDateTime($trx->created_at) }}
                                        </td>

                                        <td class="text-center">
                                            <span
                                                class="@if ($trx->trx_type == '+') text-success @else text-danger @endif">
                                                {{ $trx->trx_type }} {{ showAmount($trx->amount) }}
                                                {{ $general->cur_text }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            {{ showAmount($trx->post_balance) }}
                                            {{ __($general->cur_text) }}
                                        </td>


                                        <td>{{ __($trx->details) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">
                                            {{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
