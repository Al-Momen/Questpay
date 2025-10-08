@extends($activeTemplate . 'layouts.frontend')
@section('content')
    {{-- ==========================  Blog Section Start  ========================== --}}
    <div class="blog-page pt-120">
        <div class="container">
            <div class="row g-4 justify-content-center">
                @include($activeTemplate . 'components.blog')

                {{-- pagination --}}
                @if ($blogs->hasPages())
                    {{-- pagination --}}
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="py-4">
                                {{ paginateLinks($blogs) }}
                            </div>
                        </div>
                    </div>
                    {{-- / pagination --}}
                @endif
         
            </div>
        </div>
    </div>
    <!--==========================  Blog Details Section End  ==========================-->

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
