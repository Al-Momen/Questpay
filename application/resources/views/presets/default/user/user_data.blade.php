@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="custom--card">
        <div class="sign-up__wapper">
            <div class="wrap">
                <div class="section-heading mb-2">
                    <h2 class="section-heading__title sign-up__title title-animation">{{ __($pageTitle) }}</h2>
                </div>
            </div>
            <div class="sign-up__forms">
                <div class="sign-up__shape">
                    <img src="{{ getImage(getFilePath('shape') . 'breadcrumb-shape.png') }}" alt="@lang('sign-up__shape')">
                </div>

                <form method="POST" action="{{ route('user.data.submit') }}">
                    @csrf
                    <div class="row g-4">
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="firstname" id="firstname"
                                    value="{{ old('firstname') }}" placeholder="@lang('First Name')" required>
                                <label class="form-label" for="firstname">@lang('First Name')</label>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="lastname" id="lastname" value="{{ old('lastname') }}" placeholder="@lang('Last Name')"
                                    required>
                                <label class="form-label" for="">@lang('Last Name')</label>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}" placeholder="@lang('Address')"
                                    >
                                <label class="form-label" for="address">@lang('Address')</label>

                            </div>
                        </div>


                        <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="state" id="state" value="{{ old('state') }}" placeholder="@lang('State')"
                                    >
                                <label class="form-label" for="state">@lang('State')</label>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="zip" id="zip" value="{{ old('zip') }}" placeholder="@lang('Zip')"
                                    >
                                <label class="form-label" for="zip">@lang('Zip Code')</label>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="city" id="city" value="{{ old('city') }}" placeholder="@lang('City')"
                                    >
                                <label class="form-label" for="city">@lang('City')</label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn--base w-100">
                            @lang('Save')
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
