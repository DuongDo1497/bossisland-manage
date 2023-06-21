@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name') | @lang('Address')</th>
                                    <th>@lang('Mobile') | @lang('Email')</th>
                                    <th>@lang('Receivable')</th>
                                    <th>@lang('Payable')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $customer->name }}</span>
                                            <br>

                                            {{ strLimit($customer->address, 40) }}
                                        </td>

                                        <td>
                                            <span class="fw-bold">+{{ $customer->mobile }}</span> <br> {{ $customer->email }}
                                        </td>

                                        <td>{{ $general->cur_sym . showAmount($customer->totalReceivableAmount()) }}</td>
                                        <td>{{ $general->cur_sym . showAmount($customer->totalPayableAmount()) }}</td>

                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Edit Customer')" data-resource="{{ $customer }}">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </button>

                                                @if (isSuperAdmin())
                                                    <a class="btn btn-sm btn-outline--warning" href="{{ route('admin.customer.notification.log', $customer->id) }}"><i class="la la-bell"></i>
                                                        @lang('Notify')
                                                    </a>
                                                @endif

                                                @php
                                                    $totalReceivable = $customer->totalReceivableAmount() - abs($customer->totalPayableAmount());
                                                @endphp

                                                <a href="{{ route('admin.customer.payment.index', $customer->id) }}" @class([
                                                    'btn btn-sm btn-outline--info',
                                                    'disabled' => $totalReceivable == 0,
                                                ])>
                                                    <i class="las la-money-bill-wave-alt"></i>@lang('Payment')
                                                </a>
                                            </div>
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
                @if ($customers->hasPages())
                    <div class="card-footer py-4">
                        @php echo  paginateLinks($customers) @endphp
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Create Update Modal -->
    <div class="modal fade" id="cuModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{ route('admin.customer.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <input type="text" name="name" class="form-control" autocomplete="off" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Email')</label>
                                    <input type="email" class="form-control " name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Mobile')
                                        <i class="fa fa-info-circle text--primary" title="@lang('Type the mobile number including the country code. Otherwise, SMS won\'t send to that number.')">
                                        </i>
                                    </label>
                                    <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control " required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>@lang('Address')</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <x-search-form />

    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Customer')">
        <i class="la la-plus"></i>@lang('Add New')
    </button>
    @if (isSuperAdmin())
        <a class="btn btn-sm btn-outline--info" href="{{ route('admin.customer.notification.all') }}"><i class="la la-bell"></i>
            @lang('Notification to All')
        </a>
    @endif
@endpush
