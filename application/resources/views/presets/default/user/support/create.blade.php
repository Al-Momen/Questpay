@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-section pt-120">
        <div class="container">
            <div class="dashboard-wrapper">
                @include('Template::components.user.top_header')
                <div class="row gy-3 gy-xl-4 justify-content-end">
                    <div class="col-lg-3 text-end">
                        <a href="{{ route('ticket') }}" class="btn btn--md btn--base mb-3">@lang('My Support Ticket')</a>
                    </div>
                </div>
                <form action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="profile-items">
                        <div class="profile__wrap card p-4">
                            <div class="row g-4">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control support-readonly" id="firstName"
                                            placeholder="@lang('Name')" name="name"
                                            value="{{ $user->firstname ?? ('' . ' ' . $user->lastname ?? '') }}" required
                                            readonly>
                                        <label class="label-readonly" for="firstName">@lang('First Name')</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control support-readonly" id="email"
                                            placeholder="@lang('Email Address')" name="email" value="{{ $user->email }}"
                                            required readonly>
                                        <label class="label-readonly" for="email">@lang('Email Address')</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject"
                                            placeholder="@lang('subject')" name="subject" value="{{ old('Subject') }}"
                                            required>
                                        <label for="subject">@lang('Subject')</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="priority" required id="gateway">
                                            <option value="3">@lang('High')</option>
                                            <option value="2">@lang('Medium')</option>
                                            <option value="1">@lang('Low')</option>
                                        </select>
                                        <label for="priority">@lang('Priority')</label>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-floating">
                                        <textarea name="message" id="inputMessage" rows="10" class="form-control" required>{{ old('message') }}</textarea>
                                        <label for="state">@lang('Message')</label>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-floating">
                                        <div class="text-end">
                                            <button type="button" class="btn btn--base btn--md addFile">
                                                <i class="fa fa-plus"></i> @lang('Add New')
                                            </button>
                                        </div>
                                        <div class="file-upload">
                                            <label class="form-label">@lang('Attachments'):</label>
                                            <small class="text-danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is')
                                                {{ ini_get('upload_max_filesize') }}</small>
                                            <input type="file" name="attachments[]" id="inputAttachments"
                                                class="form-control mb-2">
                                            <div id="fileUploadsContainer"></div>
                                            <div class="d-flex justify-content-start gy-5">
                                                <p class="ticket-attachments-message">
                                                    @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'),
                                                    .@lang('png'),
                                                    .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="profile__form">
                                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }

        textarea.form-control {
            height: 230px !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required />
                        <button class="input-group-text btn--danger remove-btn"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
