@extends('admin.layouts.app')
@section('panel')
    <form method="GET" id="statusForm">
        <div class="row gy-4 justify-content-between mb-3 pb-3">
            <div class="col-xl-4 col-lg-6">
                <div class="d-flex flex-wrap justify-content-start">
                    <div class="search-input--wrap position-relative">
                        <input type="text" name="search" class="form-control" placeholder="@lang('Search Plan Title')..."
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
                                    <th>@lang('Icon')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('status')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody id="items_table__body">
                                @forelse($plans as $item)
                                    <tr>
                                        <td>#{{ $loop->iteration }}</td>
                                        <td>
                                            @php
                                                echo $item->icon;
                                            @endphp
                                        </td>
                                        <td>{{ __($item->name) }}</td>
                                        <td>{{ showAmount($item->price) }}</td>
                                        <td>
                                            @php
                                                echo $item->statusBadge($item->status);
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                                <button class="btn btn-sm editPlanBtn"
                                                    data-url="{{ route('admin.plan.update', $item->id) }}"
                                                    data-plan="{{ json_encode($item->except(['id', 'created_at', 'updated_at', 'status'])) }}"
                                                    title="@lang('Edit')">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <div class="form-group mb-0">
                                                    <label class="switch m-0" title="@lang($item->status ? 'Disable' : 'Enable')">
                                                        <input type="checkbox" class="toggle-switch confirmationBtn"
                                                            data-question="@lang('Are you sure to change this plan status?')"
                                                            data-action="{{ route('admin.plan.status', $item->id) }}"
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

                <div id="pagination-wrapper" class="pagination__wrapper py-4 {{ $plans->hasPages() ? '' : 'd-none' }}">
                    @if ($plans->hasPages())
                        {{ paginateLinks($plans) }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('breadcrumb-plugins')
        <a href="javascript:void(0)" class="btn btn-sm btn--primary addPlan">@lang('Add New')</a>
    @endpush

    {{-- Add MODAL --}}
    <div id="addPlanModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add Plan')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.plan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="icon" class="form-label">@lang('Icon')</label>
                                                    <div class="input-group">
                                                        <input type="text" name="icon" id="icon"
                                                            value="{{ old('icon') }}"
                                                            class="form-control iconPicker icon"
                                                            placeholder="@lang('Plan Icon')" required>
                                                        <span class="input-group-text  input-group-addon"
                                                            data-icon="las la-home" role="iconpicker"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group">
                                            <label for="name" class="form-label">@lang('Name')</label>
                                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                                class="form-control" placeholder="@lang('Plan Name')" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group">
                                            <label for="price" class="form-label">@lang('Price')</label>
                                            <input type="text" name="price" id="price"
                                                value="{{ old('price') }}" class="form-control" min="1"
                                                step="any" placeholder="@lang('Plan Price')" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="file-upload">
                                                        <label class="form-label">@lang('Features')</label>
                                                        <input type="text" name="features[]" id="features"
                                                            class="form-control" required
                                                            placeholder="@lang('Plan Features')">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="fileUploadsContainer">

                                            </div>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-success btn--sm addFile">
                                                    <i class="fa fa-plus"></i> @lang('New')
                                                </button>
                                            </div>
                                        </div>
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



    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editPlanModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">@lang('Edit Plan')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="icon" class="form-label">@lang('Icon')</label>
                                                    <div class="input-group">
                                                        <input type="text" name="icon" id="icon"
                                                            value="{{ old('icon') }}"
                                                            class="form-control iconPicker icon"
                                                            placeholder="@lang('Plan Icon')" required>
                                                        <span class="input-group-text  input-group-addon"
                                                            data-icon="fas fa-home" role="iconpicker"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group">
                                            <label for="name" class="form-label">@lang('Name')</label>
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name') }}" class="form-control"
                                                placeholder="@lang('Plan Name')" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group">
                                            <label for="price" class="form-label">@lang('Price')</label>
                                            <input type="text" name="price" id="price"
                                                value="{{ old('price') }}" class="form-control" min="1"
                                                step="any" placeholder="@lang('Plan Price')" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="file-upload">
                                                        <label class="form-label">@lang('Features')</label>
                                                        <input type="text" name="features[]" id="features"
                                                            class="form-control" required
                                                            placeholder="@lang('Plan Features')">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="fileUploadsContainer">

                                            </div>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-success btn--sm addFile">
                                                    <i class="fa fa-plus"></i> @lang('New')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                            value="add">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('style-lib')
    <link href="{{ asset('assets/admin/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/fontawesome-iconpicker.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('#status-filter').on('change', function() {
                $('#statusForm').submit();
            });

            $('.addPlan').on('click', function() {
                const modal = $('#addPlanModel');
                modal.find('form')[0].reset();
                modal.find('#fileUploadsContainer').empty();
                $('#addPlanModel').modal('show');
                initIconPicker(modal);
            });

            $('.editPlanBtn').on('click', function() {
                var modal = $('#editPlanModal');
                var form = $(modal).find('form');
                var plan = $(this).data('plan');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(plan.name);
                modal.find('input[name=icon]').val(plan.icon);
                modal.find('input[name=price]').val(plan.price);
                modal.find('#fileUploadsContainer').empty();

                // first value set in main input
                if (plan.features && plan.features.length > 0) {
                    modal.find('#features').val(plan.features[0]); // first index value
                    for (let i = 1; i < plan.features.length; i++) {
                        appendFeatureInput(modal, plan.features[i]);
                    }
                } else {
                    $('#features').val('');
                }
                modal.modal('show');
                initIconPicker(modal);

            });

            $(document).on('click', '.addFile', function() {
                const modal = $(this).closest('.modal');
                appendFeatureInput(modal);
            });

            $(document).on('click', '.remove-btn', function() {
                $(this).closest('.elements').remove();
            });

            function appendFeatureInput(modal, value = '') {
                modal.find('#fileUploadsContainer').append(`
                    <div class="col-sm-12 my-3 elements">
                        <div class="file-upload input-group">
                            <input type="text" name="features[]" 
                                class="form-control" required 
                                placeholder="@lang('Plan Features')" 
                                value="${value}">
                            <button type="button" class="input-group-text btn--danger remove-btn">
                                <i class="las la-times"></i>
                            </button>
                        </div>
                    </div>
                `);
            }

            function initIconPicker(modal) {
                modal.find('.iconPicker').iconpicker().off('iconpickerSelected').on('iconpickerSelected', function(e) {
                    $(this).closest('.form-group').find('.iconpicker-input').val(
                        `<i class="${e.iconpickerValue}"></i>`);
                });
            }

        })(jQuery);
    </script>
@endpush
