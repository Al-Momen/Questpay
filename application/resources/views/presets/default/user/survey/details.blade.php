@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="profile-section">
            <div class="container">
                @include('Template::components.user.top_header')
                <div class="profile-items">
                    <div class="text-end">
                        <a href="{{route('user.survey.index')}}" class="btn btn--base mb-4">@lang('Back')</a>
                    </div>
                    <div class="row g-4 justify-content-center">
                        <div class="col-lg-12">
                            <div class="profile__wrap card p-4">
                                <h5 class="mb-20">@lang('Survey Form Data')</h5>
                                @foreach ($survey['form_data']['questions'] as $q)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">{{ $q['question'] }}</label>
                                        <span class="d-block">@lang('Type'):
                                            {{ ucwords(str_replace('_', ' ', $q['type'])) }}</span>
                                        @if ($q['type'] == 'mcq_single' || $q['type'] == 'mcq_multiple')
                                            <ul class="list-group list-group-flush">
                                                @foreach ($q['options'] as $opt)
                                                    <li class="list-group-item">{{ $opt }}</li>
                                                @endforeach
                                            </ul>
                                        @elseif($q['type'] == 'written_textarea' || $q['type'] == 'written_input')
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
