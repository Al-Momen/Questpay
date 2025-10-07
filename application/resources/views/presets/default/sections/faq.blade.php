@php
    $faqSectionContent = getContent('faq.content', true);
    $faqSectionElements = getContent('faq.element', false, false, true);
@endphp

<!--=============================== faq section start ===============================-->
<section class="faq mt-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="faq-thumb">
                    <div class="faq-thumb__image text-center">
                        <img src="{{ getImage(getFilePath('faq') . $faqSectionContent->data_values->image) }}"
                            alt="@lang('faq-image')">
                        <h2 class="faq-thumb__q-shape">Q</h2>
                    </div>
                    <div class="support-bage">
                        <img class="support-bage__image"
                            src="{{ getImage(getFilePath('faq') . $faqSectionContent->data_values->support_image) }}"
                            alt="@lang('faq-support')">
                        <h3 class="support-bage__title mb-2 fs--40 fw--600">
                            {{ $faqSectionContent->data_values->support_hour }}</h3>
                        <h6 class="support-bage__desc fs--20 mb-0 fw--600">
                            {{ __($faqSectionContent->data_values->support_text) }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-heading">
                    <p class="section-heading__subtitle sub-animation">{{ __($faqSectionContent->data_values->title) }}
                    </p>
                    <h2 class="section-heading__title title-animation">
                        {{ __($faqSectionContent->data_values->heading) }}</h2>
                    <p class="section-heading__desc sub-animation">{{ __($faqSectionContent->data_values->subheading) }}
                    </p>
                </div>
                <div class="accordion" id="accordionExample">
                    @foreach ($faqSectionElements ?? [] as $index => $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $index + 1 }}"
                                    aria-expanded="{{ $index + 1 == 1 ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $index + 1 }}">
                                    {{ __($item->data_values->question) }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index + 1 }}"
                                class="accordion-collapse collapse {{ $index + 1 == 1 ? 'show' : '' }}"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @php echo $item->data_values->answer; @endphp
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!--=============================== faq section ends ===============================-->
