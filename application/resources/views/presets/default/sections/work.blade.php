@php
    $workSectionContent = getContent('work.content', true);
    $workSectionElements = getContent('work.element', false, false, true);
@endphp

<!-- how-work section start -->
<section class="work mt-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center mb-60">
                    <p class="section-heading__subtitle sub-animation">{{ __($workSectionContent->data_values->title) }}
                    </p>
                    <h2 class="section-heading__title title-animation">
                        {{ __($workSectionContent->data_values->heading) }}</h2>
                    <p class="section-heading__desc work-desc sub-animation">
                        {{ __($workSectionContent->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="work-main__items">
            @foreach ($workSectionElements ?? [] as $index=> $item)
                <div class="work-items text-center position-relative">
                    <div class="work-bg">
                        <span>
                            <img src="{{getImage(getFilePath('work').$item->data_values->image)}}" alt="@lang('account-icon')">
                        </span>
                    </div>
                    <div class="work-content">
                        <h3 class="work-content__title">{{__($item->data_values->title)}}</h3>
                        <p class="work-content__desc">{{__($item->data_values->subheading)}}</p>
                    </div>
                    <div class="card-number">
                        <span>{{ $index+1 < 10 ? '0' . $index+1 : $index+1 }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- how-work section ends -->
