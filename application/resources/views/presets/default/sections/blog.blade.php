@php
    $blogSectionContent = getContent('blog.content', true);
    $blogs = getContent('blog.element', false, 3, false);
@endphp

<!--============================ news section start  ============================-->
<section class="news pt-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="news-heading d-flex justify-content-between mb-30 flex-wrap">
                    <div class="section-heading">
                        <p class="section-heading__subtitle title-animation">
                            {{ __($blogSectionContent->data_values->top_heading) }}</p>
                        <h2 class="section-heading__title title-animation">
                            {{ __($blogSectionContent->data_values->heading) }} </h2>
                        <p class="section-heading__desc title-animation">
                            {{ __($blogSectionContent->data_values->short_description) }}</p>
                    </div>
                    <div class="news-btn">
                        <a class="hero-button btn btn--base"
                            href="{{ route('blog') }}">{{ __($blogSectionContent->data_values->button_text) }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            @include($activeTemplate . 'components.blog')
        </div>
    </div>
</section>
<!--============================ news section ends  ============================-->
