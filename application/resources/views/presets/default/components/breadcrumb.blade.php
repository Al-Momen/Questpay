<!-- ==================== Breadcrumb Start Here ==================== -->
<section class="breadcrumb position-relative">
    <div class="breadcrumb-shape"><img src="{{ asset('assets/images/frontend/shape/breadcrumb-shape.png')}}" alt="@lang("shape")"></div>
    <div class="breadcrumb-left__image"><img src="{{ asset('assets/images/frontend/shape/breadcrumb-left.png')}}" alt="@lang("left")"></div>
    <div class="breadcrumb-right__image">
        <img src="{{ asset('assets/images/frontend/shape/breadcrumb-right.png')}}" alt="@lang("right")">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper">
                    <h2 class="breadcrumb__title">{{__($pageTitle)}}</h2>
                    <ul class="breadcrumb__list">
                        <li class="breadcrumb__item"><a href="{{route('home')}}" class="breadcrumb__link">@lang('Home')</a></li>
                        <li class="breadcrumb__item">/</li>
                        <li class="breadcrumb__item"><span class="breadcrumb__item-text">{{__($pageTitle)}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcrumb End Here ==================== -->
