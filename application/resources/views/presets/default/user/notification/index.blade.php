@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="survey-list pt-120">
        <div class="container">
            <div class="survey-list__main">
                @include('Template::components.user.top_header')
                   <div class="row justify-content-end">
                    <div class="col-lg-3 ">
                        <form action="">
                            <div class="form-floating">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{ request()->search }}"
                                        placeholder="@lang('Search TRX')">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="dashboard-table card mt-4 mt-xl-4">
                          <h3 class="dashboard-table__title fs--16 fw--700 mb--16">@lang('Notification List')</h3>
                    <div class="dashboard-table__items">
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('SI No')</th>
                                    <th class="text-center">@lang('Title')</th>
                                    <th class="text-center">@lang('Read Status')</th>
                                    <th class="text-center">@lang('Date')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notifications ?? [] as $item)
                                    <tr>
                                        <td data-label="@lang('SI No')">#{{ $loop->iteration }}</td>
                                        <td data-label="@lang('Title')">{{ __(strLimit($item->title, 50)) }}</td>
                                        <td data-label="@lang('Read Status')">
                                            @php
                                                echo $item->statusBadge($item->status);
                                            @endphp
                                        </td>
                                        <td data-label="@lang('Date')" class="text-center">
                                            {{ showDateTime($item->created_at) }} </td>


                                        <td data-label="@lang('Details')">
                                            <a href="{{ route('user.read.notification', $item->id) }}"
                                                class="btn btn--base btn--sm action--btn">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
