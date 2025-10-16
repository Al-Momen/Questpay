@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="about mt-120">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="deshboard-bottom mb-4">
                    <div class="filter__wrap">
                        <div class="survey-list__bottom-main d-flex justify-content-between flex-wrap">
                            <h3 class="deshboard-bottom__title m-0">@lang('Survey')</h3>
                            <form action="" post="get">
                                <div class="input-search__box d-flex gap--12">
                                    <div class="search__box  position-relative">
                                        <input type="text" class="form-control bottom-search__box" name="search"
                                            placeholder="@lang('Search Survey')..." value="{{ request()->search }}">
                                        <button class="" type="submit">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrap">
                                        <span class="filter__btn">
                                            <i class="fa-solid fa-filter"></i>
                                        </span>
                                        <div class="filter__main">
                                            <div class="filter-meading__section">
                                                <div class="text-end">
                                                    <span class="filter__close">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </span>
                                                </div>
                                                <div
                                                    class="filter-heading d-flex justify-content-between align-items-center mt-3 mb-4">
                                                    <h3 class="filter-heading__title fs--20 fw--600 mb-0">@lang('Filter')
                                                    </h3>
                                                    <p class="filter-heading__clear-btn cursor-pointer clearAll">
                                                        @lang('Clear All')
                                                    </p>
                                                </div>
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <h4 class="category-title fs--16 fw--600 mb-2">@lang('Category')
                                                        </h4>
                                                        @php
                                                            $selectedCategories = request()->category_id ?? [];
                                                        @endphp
                                                        <div class="filter__form">
                                                            @foreach ($categories ?? [] as $item)
                                                                <div
                                                                    class="form-check d-flex justify-content-between align-items-center mb-4">
                                                                    <label class="form-check-label fs--16 text-black"
                                                                        for="cat_{{ $item->id }}">
                                                                        {{ __($item->name) }}
                                                                    </label>

                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="category_id[]" value="{{ $item->id }}"
                                                                        id="cat_{{ $item->id }}"
                                                                        {{ in_array($item->id, $selectedCategories) ? 'checked' : '' }}>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dashboard-list__button w--100 mt-4">
                                                    <button class="filter--btn w--100 fs--16 fw--600"
                                                        type="submit">@lang('Search')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="deshboard-list">
                    <div class="row g-4">
                        @foreach ($surveys ?? [] as $item)
                            <div class="col-lg-4 col-md-6">
                                <div class="dashboard-list__items">
                                    <a href="{{ route('survey.details', $item->id) }}"
                                        class="dashboard-list__thumb mb-3 w--100">
                                        <img class="w--100 radius--12"
                                            src="{{ getImage(getFilePath('survey') . '/' . $item->image) }}"
                                            alt="@lang('dashboard-img')">
                                    </a>
                                    <div class="dashboard-list__content">
                                        <a href="{{ route('survey.details', $item->id) }}">
                                            <h3 class="dashboard-list__title fs--20 fw--700 ps-3">{{ $item->title }}</h3>
                                        </a>
                                        <div class="dashboard-list__catagory d-flex justify-content-between">
                                            <div class="left-tag ps-3">
                                                <p class="fs-16 fw--400">
                                                    <span class="pe-2">
                                                        <i class="fa-solid fa-tag"></i>
                                                    </span>@lang('Category')
                                                </p>
                                                <p class="fs-16 fw--400 text--black ps-4">{{ __($item->category->name) }}
                                                </p>
                                            </div>
                                            <div class="dashboard-list__line"></div>
                                            <div class="right-tag pe-3">
                                                <p class="fs-16 fw--400"><span class="pe-2">
                                                        <i class="fa-solid fa-circle-question"></i>
                                                    </span>@lang('Per Question')</p>
                                                <p class="fs-16 fw--400 text--black ps-4">
                                                    {{ $general->cur_sym }}{{ showAmount($item->survey_money) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="dashboard-list__bottom d-flex justify-content-between align-items-center p-3">
                                            <div class="dashboard-list__mouny">
                                                <h3 class="dashboard-list__mouny-title fs--24 fw--700 text--black m-0">
                                                    {{ $general->cur_sym }}{{ $item->total_amount }}
                                                </h3>
                                                <p class="dashboard-list__mouny-desc">@lang('Total Amount')</p>
                                            </div>
                                            <div class="dashboard-list__button">
                                                <a class="btn btn--base custom--btn"
                                                    href="{{ route('survey.details', $item->id) }}">
                                                    @lang('Start Survey')
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        (function($) {
            'use strict';
            $(document).ready(function() {
                $('.clearAll').on('click', function() {
                    $('input[type="checkbox"][name="category_id[]"]').prop('checked', false);
                });
            });
        })(jQuery);
    </script>
@endpush
