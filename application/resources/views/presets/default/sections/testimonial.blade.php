@php
    $testimonialSectionContent = getContent('testimonial.content', true);
    $testimonialSectionElements = getContent('testimonial.element', false, 8, true);
@endphp

<!--=========================== testimonials section start ===========================-->
<section class="testimonials mt-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center mb-60">
                    <p class="section-heading__subtitle sub-animation">
                        {{ __($testimonialSectionContent->data_values->title) }}</p>
                    <h2 class="section-heading__title sub-animation">
                        {{ __($testimonialSectionContent->data_values->heading) }}</h2>
                    <p class="section-heading__desc testimonials--desc sub-animation">
                        {{ __($testimonialSectionContent->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ($testimonialSectionElements ?? [] as $item)
                    <div class="swiper-slide">
                        <div class="testimonials-card">
                            <div class="testimonials-content">
                                <h4 class="testimonials-title">{{ __($item->data_values->name) }}</h4>
                                <p class="testimonials-subtitle">{{ __($item->data_values->location) }}</p>
                                <p class="testimonials-desc">{{ __($item->data_values->short_description) }}</p>
                                <div class="rating d-flex align-items-center gap--20">
                                    <ul class="star__rating">
                                        @for ($i = 0; $i < $item->data_values->rating_number; $i++)
                                            <li><i class="fas fa-star"></i></li>
                                        @endfor

                                    </ul>
                                    <h2 class="testimonials-point">{{ __($item->data_values->rating_number) }}</h2>
                                </div>
                            </div>
                            <div class="testimonials-thumb">
                                <img src="{{ getImage(getFilePath('testimonial') . $item->data_values->image) }}"
                                    alt="testimonials">
                            </div>
                            <div class="testimonials-tag">
                                <span>
                                    <svg width="65" height="47" viewBox="0 0 65 47" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M65 29.2031C65 38.6561 57.2087 46.3125 47.5893 46.3125H46.4286C43.8605 46.3125 41.7857 44.2736 41.7857 41.75C41.7857 39.2264 43.8605 37.1875 46.4286 37.1875H47.5893C52.0725 37.1875 55.7143 33.6088 55.7143 29.2031V28.0625H46.4286C41.3069 28.0625 37.1429 23.9705 37.1429 18.9375V9.8125C37.1429 4.77949 41.3069 0.6875 46.4286 0.6875H55.7143C60.8359 0.6875 65 4.77949 65 9.8125V14.375V18.9375V29.2031ZM27.8571 29.2031C27.8571 38.6561 20.0658 46.3125 10.4464 46.3125H9.28571C6.71763 46.3125 4.64286 44.2736 4.64286 41.75C4.64286 39.2264 6.71763 37.1875 9.28571 37.1875H10.4464C14.9297 37.1875 18.5714 33.6088 18.5714 29.2031V28.0625H9.28571C4.16406 28.0625 0 23.9705 0 18.9375V9.8125C0 4.77949 4.16406 0.6875 9.28571 0.6875H18.5714C23.6931 0.6875 27.8571 4.77949 27.8571 9.8125V14.375V18.9375V29.2031Z"
                                            fill="hsl(var(--base))" fill-opacity="0.17" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!--=========================== testimonials section ends ===========================-->
