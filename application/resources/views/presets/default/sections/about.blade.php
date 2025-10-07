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
                        <img class="about-thumb__image" src="{{getImage(getFilePath('about').$aboutSectionContent->data_values->image)}}" alt="@lang('about-image')">
                    </div>
                    <div class="about-counter">
                        <img class="about-counter__image" src="{{getImage(getFilePath('about').'about-image.png')}}"
                            alt="@lang('about-img')">
                        <h4 class="about-counter__title mb-0 fs--32  fw--600 "><span class="odometer text-black"
                                data-odometer-final="{{$aboutSectionContent->data_values->counter_number}}">0</span>+</h4>
                        <h6 class="fs--20 mb-0 fw--600">{{__($aboutSectionContent->data_values->counter_text)}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section-heading mb-4">
                        <p class="section-heading__subtitle sub-animation">{{__($aboutSectionContent->data_values->title)}}</p>
                        <h2 class="section-heading__title title-animation">
                            {{__($aboutSectionContent->data_values->heading)}}
                        </h2>
                        <p class="section-heading__desc sub-animation">{{__($aboutSectionContent->data_values->subheading)}}</p>
                    </div>
                    <div class="about-tab">
                        <div class="about-section__content">
                            <ul class="nav custom--tab nav-pills" id="about-tab" role="tablist">
                                <li class="nav-item active" role="presentation">
                                    <button class="nav-link tab--link active" id="pills-1-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1"
                                        aria-selected="true">
                                        Mission
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link tab--link" id="pills-2-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2"
                                        aria-selected="false" tabindex="-1">
                                        Vision
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link tab--link" id="pills-3-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-3" type="button" role="tab" aria-controls="pills-3"
                                        aria-selected="false" tabindex="-1">
                                        Values
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="about-tabContent">
                                <div class="tab-pane fade active show" id="pills-1" role="tabpanel"
                                    aria-labelledby="pills-1-tab" tabindex="0">
                                    <p class="about-section__desc">Our mission is to make collecting feedback
                                        easy, accessible, and impactful for everyone from individuals
                                        to global businesses.</p>
                                    <div class="about-section-list">
                                        <div class="d-flex gap--12 flex-wrap mb-4 ">
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                        </div>
                                        <div class="d-flex gap--12 flex-wrap">
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab"
                                    tabindex="0">
                                    <p class="about-section__content-desc">we are revolutionizing mobile
                                        connectivity
                                        with
                                        cutting-edge
                                        eSIM technology. As a leading eSIM service provider,</p>
                                    <div class="about-section-list mt-30">
                                        <div class="d-flex gap--24 flex-wrap mb-3">
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                        </div>
                                        <div class="d-flex gap--24 flex-wrap mb-3">
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                        </div>
                                        <div class="d-flex gap--24 flex-wrap mb-3">
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-3" role="tabpanel"
                                    aria-labelledby="pills-3-tab" tabindex="0">
                                    <p class="about-section__content-desc mb-30">Our mission is to make
                                        collecting
                                        feedback
                                        easy, accessible, and impactful for everyone from individuals to global
                                        businesses.</p>
                                    <div class="about-section-list">
                                        <div class="d-flex gap--24 flex-wrap mb-3">
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                        </div>
                                        <div class="d-flex gap--24 flex-wrap mb-3">
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                        </div>
                                        <div class="d-flex gap--24 flex-wrap mb-3">
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                        </div>
                                        <div class="d-flex gap--24 flex-wrap mb-3">
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                            <p class="about-section-list__item">
                                                <span class="icon"><i class="fa-solid fa-circle-check"></i>
                                                </span>
                                                General & Clear
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <a class="hero-button btn btn--base mt-30" href="#">{{__($aboutSectionContent->data_values->button_text)}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================================ about section ends =================================-->
