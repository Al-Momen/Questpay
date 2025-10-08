@php
    $aboutSectionContent = getContent('about.content', true);
    $aboutSectionElements = getContent('about.element', false, false, true);
@endphp
<!--================================ about section start ================================-->
<section class="about mt-120">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-6">
                <div class="about-thumb">
                    <div class="about__img">
                        <img class="about-thumb__image"
                            src="{{ getImage(getFilePath('about') . $aboutSectionContent->data_values->image) }}"
                            alt="@lang('about-image')">
                    </div>
                    <div class="about-counter">
                        <img class="about-counter__image" src="{{ getImage(getFilePath('about') . 'about-image.png') }}"
                            alt="@lang('about-img')">
                        <h4 class="about-counter__title mb-0 fs--32  fw--600 "><span class="odometer text-black"
                                data-odometer-final="{{ $aboutSectionContent->data_values->counter_number }}">0</span>+
                        </h4>
                        <h6 class="fs--20 mb-0 fw--600">{{ __($aboutSectionContent->data_values->counter_text) }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section-heading mb-4">
                        <p class="section-heading__subtitle sub-animation">
                            {{ __($aboutSectionContent->data_values->title) }}</p>
                        <h2 class="section-heading__title title-animation">
                            {{ __($aboutSectionContent->data_values->heading) }}
                        </h2>
                        <p class="section-heading__desc sub-animation">
                            {{ __($aboutSectionContent->data_values->subheading) }}</p>
                    </div>
                    <div class="about-section__content">
                        <div class="about-section-list">
                            <div class="row">
                                @foreach ($aboutSectionElements ?? [] as $item)
                                    <div class="col-6 mb-3">
                                        <p class="about-section-list__item">
                                            <span class="icon">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </span>
                                            {{__($item->data_values->feature)}}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            <a class="hero-button btn btn--base mt-30"
                                href="{{route('about')}}">{{ __($aboutSectionContent->data_values->button_text) }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================================ about section ends =================================-->
