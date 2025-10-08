<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ $general->siteName(__('404')) }}</title>
    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ siteFavicon() }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
</head>

<body>
    <main>
        <!--==========================  404 Section Start  ==========================-->
        <div class="error">
            <div class="error-left__img">
                <img src="{{getImage(getFilePath('shape').'left-error.png')}}" alt="@lang('left-error')">
            </div>
            <div class="error-right__img">
                <img src="{{getImage(getFilePath('shape').'breadcrumb-shape.png')}}" alt="@lang('left-error')">
            </div>
            <div class="error-dot-shape">
                <img src="{{getImage(getFilePath('shape').'dot-shape.png')}}" alt="@lang('dot-shape')">
            </div>
            <div class="error-right-dot__shape">
                <img src="{{getImage(getFilePath('shape').'right-dot__shape.png')}}" alt="@lang('dot__shape')">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="error__main py-60">
                            <img src="{{getImage(getFilePath('error').'419.png')}}" alt="@lang('error-image')">
                            <h3 class="error-text">@lang('The page you are looking for might have been removed had its name changed or is temporarily unavailable.')</h3>
                            <a href="{{ route('home') }}" class="btn btn--base">@lang('Back to Home')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--==========================  404 Section End  ==========================-->
    </main>
</body>

</html>

