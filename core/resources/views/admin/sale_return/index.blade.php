@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 bg--transparent">
                <div class="card-body p-0 ">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two bg-white">
                            <thead>
                                <tr>
                                    <th>@lang('Invoice No.') | @lang('Date')</th>
                                    <th>@lang('Customer') | @lang('Mobile')</th>
                                    <th>@lang('Warehouse') | @lang('Total Amount')</th>
                                    <th>@lang('Discount') | @lang('Payable')</th>
                                    <th>@lang('Paid') | @lang('Due')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($saleReturns as $return)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">
                                                {{ $return->sale->invoice_no }}
                                            </span>

                                            <br>
                                            <em>{{ showDateTime($return->return_date, 'd M, Y') }}</em>
                                        </td>
                                        <td>
                                            <span class="fw-bold text--primary">{{ $return->customer->name }}</span>
                                            <br>
                                            {{ $return->customer->mobile }}
                                        </td>
                                        <td>
                                            {{ $return->sale->warehouse->name }}
                                            <br>
                                            <span class="fw-bold"> {{ $general->cur_sym . showAmount($return->total_price) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $general->cur_sym . showAmount($return->discount_amount) }}
                                            <br>
                                            <span class="fw-bold">
                                                {{ $general->cur_sym . showAmount($return->payable_amount) }}</span>
                                        </td>

                                        <td>
                                            {{ $general->cur_sym . showAmount($return->paid_amount) }}
                                            <br>
                                            @if ($return->due_amount < 0)
                                                <span class="text--danger fw-bold" title="@lang('Receivable from Customer')">
                                                    - {{ $general->cur_sym . showAmount(abs($return->due_amount)) }}
                                                </span>
                                            @else
                                                <span class="fw-bold" title="@lang('Payable to Customer')">
                                                    {{ $general->cur_sym . showAmount($return->due_amount) }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.sale.return.edit', $return->id) }}" class="btn btn-sm btn-outline--primary ms-1 editBtn"><i class="las la-pen"></i> @lang('Edit')
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline--info ms-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="la la-ellipsis-v"></i>@lang('More')
                                                </button>

                                                <ul class="dropdown-menu">
                                                    @if ($return->due_amount)
                                                        <li>
                                                            <a href="javascript:void(0)" class="dropdown-item paymentModalBtn" data-customer_id="{{ $return->customer_id }}" data-customer="{{ $return->customer->name }}" data-invoice="{{ $return->sale->invoice_no }}" data-id="{{ $return->id }}" data-due_amount="{{ $return->due_amount }}">
                                                                @if ($return->due_amount > 0)
                                                                    <i class="la la-money-bill-wave"></i>
                                                                    @lang('Give Payment')
                                                                @elseif($return->due_amount < 0)
                                                                    <i class="la la-hand-holding-usd"></i>
                                                                    @lang('Receive Payment')
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.sale.return.pdf', $return->id) }}"><i class="la la-download"></i>
                                                            @lang('Download Invoice')
                                                        </a>
                                                    </li>
                                                </ul>
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
                @if ($saleReturns->hasPages())
                    <div class="card-footer py-4">
                        @php echo  paginateLinks($saleReturns) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
    <!-- Start Payment Modal  -->
    <div id="paymentModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Payment')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Invoice No.')</label>
                            <input type="text" class="form-control invoice-no" readonly>
                        </div>
                        <div class="form-group">
                            <label>@lang('Customer')</label>
                            <input type="text" class="form-control customer-name" readonly>
                        </div>
                        <div class="form-group">
                            <label class="amountType"></label>
                            <div class="input-group">
                                <button type="button" class="input-group-text">{{ $general->cur_sym }}</button>
                                <input type="text" class="form-control payable_amount" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="payment-type"></label>
                            <div class="input-group">
                                <button type="button" class="input-group-text">{{ $general->cur_sym }}</button>
                                <input type="number" step="any" name="amount" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100 permit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Start Payment Modal  -->
@endsection

@push('style')
    <style>
        .table-responsive {
            min-height: 400px;
            background: transparent
        }

        .card {
            box-shadow: none;
        }
    </style>
@endpush

@push('breadcrumb-plugins')
    <x-search-form dateSearch='yes' />
@endpush


@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.paymentModalBtn', function() {
                var modal = $('#paymentModal');
                let data = $(this).data();
                var due = parseFloat(Math.abs(data.due_amount)).toFixed(2);

                let amountTypeLabel = modal.find('.amountType')
                let payingReceivingLabel = modal.find('.payment-type')

                if (parseFloat(data.due_amount).toFixed(2) > 0) {
                    amountTypeLabel.text(`@lang('Payable Amount')`);
                    payingReceivingLabel.text(`@lang('Paying Amount')`);
                } else {
                    amountTypeLabel.text(`@lang('Receivable Amount')`);
                    payingReceivingLabel.text(`@lang('Receiving Amount')`);
                }

                modal.find('.invoice-no').val(`${data.invoice}`);
                modal.find('.customer-name').val(`${data.customer}`);

                modal.find('.payable_amount').val(`${due}`);
                let form = modal.find('form')[0];
                form.action = `{{ route('admin.customer.payment.payable.store', '') }}/${data.id}`
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
