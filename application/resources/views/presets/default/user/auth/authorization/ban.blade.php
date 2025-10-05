@extends($activeTemplate .'layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-end">
                <a href="{{ route('home') }}" class="fw--500 home-link"> <i class="fa-solid fa-arrow-left-long"></i> @lang('Go to Home')</a>
            </div>
            <div class="card custom--card">
                <div class="card-body">
                    <h3 class="text-center text-danger">@lang('You are banned')</h3>
                    <p class="fw--500 mb-1">@lang('Reason'):</p>
                    <p>{{ $user->ban_reason }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
