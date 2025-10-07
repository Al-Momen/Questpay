@php
    $informationSectionContent = getContent('information.content', true);
@endphp
<!--============================== cta section start =============================-->
<section class="cta mt-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="cta-left">
                    <div class="cta-thumb w--100 pb-40">
                        <img class="w--100" src="{{getImage(getFilePath('information').$informationSectionContent->data_values->left_image)}}" alt="@lang('information-image')">
                    </div>
                    <div class="cta-content">
                        <h2 class="cta-left__title title-animation">{{__($informationSectionContent->data_values->left_heading)}}</h2>
                        <p class="cta-left__desc sub-animation">{{__($informationSectionContent->data_values->left_subheading)}}</p>
                        <a class="hero-button btn btn--base" href="{{__($informationSectionContent->data_values->left_button_url)}}">{{__($informationSectionContent->data_values->left_button_text)}}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="cta-right d-flex flex-column justify-content-end bg--img"
                    data-background-image="{{getImage(getFilePath('information').$informationSectionContent->data_values->right_image)}}">
                    <div class="cta-right__content">
                        <h2 class="cta-right__title title-animation">{{__($informationSectionContent->data_values->right_heading)}}
                        </h2>
                        <p class="cta-right__desc sub-animation">{{__($informationSectionContent->data_values->right_subheading)}}</p>
                        <a class="hero-button btn btn--base" href="{{__($informationSectionContent->data_values->right_button_url)}}">
                           {{__($informationSectionContent->data_values->right_button_text)}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================== cta section ends ==============================-->
