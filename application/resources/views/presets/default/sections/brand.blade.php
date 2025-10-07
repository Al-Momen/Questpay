@php
    $brandSectionContent = getContent('brand.content', true);
    $brandSectionElements = getContent('brand.element', false, false, true);
@endphp

<!--====================== brand section start ======================-->
<section class="brand mt-120">
    <div class="container">
        <div class="brand-items">
            <h6 class="brand-title m-0">{{ __($brandSectionContent->data_values->heading) }}</h6>
            <div class="swiper brand-slider">
                <div class="swiper-wrapper slide-transition">
                    @foreach ($brandSectionElements ?? [] as $item)
                        <div class="swiper-slide">
                            <img src="{{getImage(getFilePath('brand').$item->data_values->brand_image)}}" alt="@lang('brand-logo')">
                        </div>
                    @endforeach
                   
                </div>
            </div>
        </div>
    </div>
</section>
<!--====================== brand section ends =======================-->
