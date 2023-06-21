@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Mobile | Email')</th>
                                    <th>@lang('Payable')</th>
                                    <th>@lang('Receivable')</th>

                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                                        <td>{{ $supplier->name }}</td>
                                        <td><span class="fw-bold"> {{ $supplier->mobile }} </span><br> {{ $supplier->email }} </td>

                                        <td>{{ $general->cur_sym . showAmount($supplier->totalPayableAmount()) }}</td>
                                        <td>{{ $general->cur_sym . showAmount($supplier->totalReceivableAmount()) }}</td>

                                        <td>
                                            <div class="button--group">

                                                <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $supplier }}" data-modal_title="@lang('Edit Supplier')">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </button>

                                                @php
                                                    $totalPayable = $supplier->totalPayableAmount() - abs($supplier->totalReceivableAmount());
                                                @endphp

                                                <a href="{{ route('admin.supplier.payment.index', $supplier->id) }}" @class([
                                                    'btn btn-sm btn-outline--info',
                                                    'disabled' => $totalPayable == 0,
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
                @if ($suppliers->hasPages())
                    <div class="card-footer py-4">
                        @php echo  paginateLinks($suppliers) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>

    <div class="modal fade" id="cuModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{ route('admin.supplier.store') }}" method="POST">
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
                                    <label class="form-label">@lang('E-Mail')</label>
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
                                    <label>@lang('Company')</label>
                                    <input type="text" name="company_name" class="form-control" autocomplete="off" value="{{ old('company_name') }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
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

    <button type="button" class="btn btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Supplier')">
        <i class="la la-plus"></i>@lang('Add New')
    </button>
@endpush
