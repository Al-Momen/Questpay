@extends('admin.layouts.app')
@section('panel')
    <form method="GET" id="statusForm">
        <div class="row gy-4 justify-content-between mb-3 pb-3">
            <div class="col-xl-4 col-lg-6">
                <div class="d-flex flex-wrap justify-content-start">
                    <div class="search-input--wrap position-relative">
                        <input type="text" name="search" class="form-control" placeholder="@lang('Search issue')..."
                            value="{{ request()->search ?? '' }}">
                        <button class="search--btn position-absolute"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-6">
                <div class="d-flex justify-content-end">
                    <select id="status-filter" name="status" class="form-control form-select bg--transparent outline">
                        <option value="all" {{ request()->status == 'all' ? 'selected' : '' }}>@lang('All')</option>
                        <option value="enable" {{ request()->status == 'enable' ? 'selected' : '' }}>@lang('Enable')
                        </option>
                        <option value="disable" {{ request()->status == 'disable' ? 'selected' : '' }}>@lang('Disable')
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </form>

    <div class="row gy-4">
        <div class="col-md-12 mb-30">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('SI')</th>
                                    <th>@lang('Month')</th>
                                    <th>@lang('Number')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody id="items_table__body">
                                @forelse($surveys as $item)
                                    <tr>
                                        <td>#{{ $loop->iteration }}</td>
                                        <td>{{ $item->month }}</td>
                                        <td>{{ $item->number < 10 ? '0' . $item->number : $item->number }}</td>
                                        <td>
                                            @php
                                                echo $item->statusBadge($item->status);
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                                <div class="form-group mb-0">
                                                    <label class="switch m-0" title="@lang($item->status ? 'Disable' : 'Enable')">
                                                        <input type="checkbox" class="toggle-switch confirmationBtn"
                                                            data-question="@lang('Are you sure to change this issue status?')"
                                                            data-action="{{ route('admin.issue.status', $item->id) }}"
                                                            @checked($item->status)>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty

                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="pagination-wrapper" class="pagination__wrapper py-4 {{ $surveys->hasPages() ? '' : 'd-none' }}">
                    @if ($surveys->hasPages())
                        {{ paginateLinks($surveys) }}
                    @endif
                </div>
            </div>
        </div>
    </div>
        @push('breadcrumb-plugins')
        <a href="{{route('admin.survey.create')}}" class="btn btn-sm btn--primary addTopic">@lang('Add New')</a>
    @endpush

    {{-- Add METHOD MODAL --}}
    <div id="addIssueModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add Issue')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.survey.store') }}" class="edit-route" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>@lang('Issue Month')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control monthPicker"
                                            placeholder="@lang('Select Month')" autocomplete="off" name="month" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>@lang('Issue Number')</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" autocomplete="off" placeholder="@lang('Number')" name="number" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/airpicker.css') }}">
@endpush

@push('style')
    <style>
        .air-datepicker-global-container {
            z-index: 9999;
        }
    </style>
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/airpicker.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.addIssue').on('click', function() {
                $('#addIssueModel').modal('show');
            });

             new AirDatepicker('.monthPicker', {
                view: 'months',
                minView: 'months',
                dateFormat: 'MMMM',
                autoClose: true,
                locale: {
                    days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                        'Nov', 'Dec'
                    ],
                    today: 'Today',
                    clear: 'Clear',
                    dateFormat: 'MMMM',
                    timeFormat: 'hh:ii aa',
                    firstDay: 0
                }

            });

        
            $('#status-filter').on('change', function() {
                $('#statusForm').submit();
            });

        })(jQuery);
    </script>
@endpush
