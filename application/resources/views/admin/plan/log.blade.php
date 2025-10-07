@extends('admin.layouts.app')
@section('panel')
@include('admin.components.tabs.plan')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('SI')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Plan Name')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Credit')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($planLogs as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.detail', @$item->user?->id) }}">{{ @$item->user?->fullname }}
                                                ({{ @$item->user?->username }})
                                            </a>
                                        </td>

                                        <td>
                                            {{ __(@$item->plan->name) }}
                                        </td>

                                        <td>
                                            {{gs()->cur_sym . __(@$item->plan->price) }}
                                        </td>

                                        <td>
                                            {{ __(@$item->plan->credit) }}
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($planLogs->hasPages())
                <div class="card-footer py-4">
                    @php echo paginateLinks($planLogs) @endphp
                </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>


    {{-- New Sub-Category Modal --}}
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"> @lang('Add Plan')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.plan.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row form-group">
                            <label>@lang('Name')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name"
                                    required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label>@lang('Price')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('price') }}" name="price"
                                    required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label>@lang('Days')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('days') }}" name="days"
                                    required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>@lang('Status')</label>
                            <div class="col-sm-12">
                                <select name="status" id="setDefault" class="form-control">
                                    <option value="1">@lang('Active')</option>
                                    <option value="0">@lang('Disable')</option>
                                </select>
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
@endsection
