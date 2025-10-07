@php
    $bannerSectionContent = getContent('banner.content', true);
    $bannerSectionElements = getContent('banner.element', false,false,true);
@endphp


<!-- ==============================Hero section start============================== -->
<section class="hero position-relative">
    <h1 class="hero-text">{{ $general->site_name }}</h1>
    <div class="hero-shape">
        <img class="pointer-event" src="{{ getImage(getFilePath('banner') . '/hero-circle.png') }}"
            alt="@lang('circle')">
    </div>
    <div class="hero-left__image">
        <img src="{{ getImage(getFilePath('banner') . '/' . $bannerSectionContent->data_values->left_image) }}"
            alt="@lang('left image')">
    </div>
    <div class="hero-right__image">
        <img src="{{ getImage(getFilePath('banner') . '/' . $bannerSectionContent->data_values->right_image) }}"
            alt="@lang('right image')">
    </div>
    <div class="hero-texture m-0">
        <img src="{{ getImage(getFilePath('banner') . '/hero-textute.png') }}" alt="@lang('texture')">
    </div>
    <div class="container">
        <div class="row">
            <div class="cal-lg-12">
                <div class="hero-item">
                    <div class="contributor-section mb-30">
                        <div class="hero-contributor">
                            @foreach ($bannerSectionElements ?? [] as $item)
                                <img src="{{getImage(getFilePath('banner'). '/'.$item->data_values->contributor_image)}}" alt="@lang('contributor-image')">
                            @endforeach

                        </div>
                        <p class="hero-contributor__title">
                            {{ __($bannerSectionContent->data_values->contributor_text) }}<span
                                class="fs-16 fw--500 bold-title">{{ $bannerSectionContent->data_values->contributor_number }}</span>
                        </p>
                    </div>
                    <div class="hero-content text-center">
                        <h2 class="hero-title sub-animation mb-30">
                            {{ __($bannerSectionContent->data_values->heading) }}</h2>
                        <p class="hero-desc sub-animation">{{ __($bannerSectionContent->data_values->sub_heading) }}
                        </p>
                        <a class="hero-button btn btn--base"
                            href="#">{{ __($bannerSectionContent->data_values->button_text) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==============================Hero section start============================== -->
