@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-3">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action=" {{ $route }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Invoice No:')</label>
                                    <input type="text" value="{{ @$sale->invoice_no }}" class="form-control" required disabled>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Customer')</label>
                                    <input type="text" value="{{ $sale->customer->name }}" class="form-control" required disabled>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Date')</label>
                                    <input name="return_date" type="text" data-language="en" class="datepicker-here form-control bg--white" data-position='bottom left' autocomplete="off" value="{{ old(date('m/d/Y'), showDateTime(@$sale->return_date, 'm/d/Y')) }}" required>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Warehouse')</label>
                                    <input type="text" value="{{ $sale->warehouse->name }}" class="form-control" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="table-responsive">
                                <table class="productTable table border">
                                    <thead class="border bg--dark">
                                        <tr>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Sale Qty')</th>
                                            <th>@lang('In Stock')</th>
                                            <th class="qty-field">@lang('Return Qty')<span class="text--danger">*</span></th>
                                            <th>@lang('Price')</th>
                                            <th>@lang('Total')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $grandTotal = 0;
                                        @endphp

                                        @foreach ($detailsData as $return)
                                            <tr>
                                                <td>{{ $return->product->name }}</td>

                                                <td>
                                                    @php
                                                        $saleQuantity = $sale->saleDetails->where('product_id', $return->product_id)->first()->quantity;
                                                    @endphp

                                                    <span class="sale-qty">{{ $saleQuantity }}</span> {{ $return->product->unit->name }}
                                                </td>


                                                <td>
                                                    @php
                                                        $quantity = $return->product->productStock->where('warehouse_id', $sale->warehouse_id)->first()->quantity;
                                                    @endphp

                                                    <span class="stock-qty">{{ $quantity }}</span> {{ $return->product->unit->name }}
                                                </td>

                                                <td class="text-start">
                                                    <input type="hidden" name="products[{{ $loop->index }}][product_id]" value="{{ $return->product->id }}" required>
                                                    <input type="hidden" name="products[{{ $loop->index }}][price]" value="{{ $return->price }}" required>

                                                    <div class="input-group">
                                                        <input type="number" name="products[{{ $loop->index }}][quantity]" value="{{ $edit ? $return->quantity : 0 }}" class="form-control quantity" data-qty="{{ @$return->quantity }}" required>
                                                        <span class="input-group-text">{{ $return->product->unit->name }}</span>
                                                    </div>

                                                    <span class="error-message text--danger"></span>
                                                </td>

                                                <td>
                                                    {{ $general->cur_sym }}<span class="sale-price">{{ $return->price }}</span>
                                                </td>

                                                @php
                                                    $totalPrice = $edit ? $return->quantity * $return->price : 0;
                                                    $grandTotal += $totalPrice;
                                                @endphp
                                                <td>
                                                    {{ $general->cur_sym }}<span class="total-price">{{ $totalPrice }}</span>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if (!blank($detailsData))
                                            <tr>
                                                <td colspan="100%" class="text-end fw-bold">
                                                    @lang('Total Price'): {{ $general->cur_sym }}<span class="grand-total">{{ showAmount($grandTotal) }}</span>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Note')</label>
                                    <textarea name="note" class="form-control">{{ old('note', @$saleReturn->note) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label> @lang('Discount')</label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                @php $discount = $edit ? showAmount(@$saleReturn->discount_amount) : 0; @endphp
                                                <input type="number" step="any" name="discount" class="form-control" value="{{ old('discount', $discount) }}">
                                            </div>
                                            <span class="error-message text--danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>@lang('Payable to Customer')</label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                @php $returnAmount = $edit ? @$saleReturn->payable_amount : 0; @endphp
                                                <input type="number" class="form-control return_amount" value="{{ getAmount($returnAmount) }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($edit)
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>@lang('Paid Amount')</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                    <input type="number" name="paid_amount" class="form-control" value="{{ getAmount(@$saleReturn->paid_amount) }}" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>@lang('Due Amount')</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                    <input type="number" class="form-control due_amount" value="{{ getAmount(@$saleReturn->due_amount) }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn--primary w-100 h-45 submit-btn">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.sale.return.index') }}"></x-back>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush

@push('style')
    <style>
        .table td {
            white-space: unset;
            padding: 8px 15px;
        }

        .qty-field {
            min-width: 250px;
            width: 250px
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            let error = false;
            let isEdit = {{ $edit }};

            $('.select2-basic').select2({
                dropdownParent: $('.card-body')
            });


            $("[name=discount]").on('input', function() {
                let grandTotal = $('.grand-total').text() * 1;

                if (this.value < 0) {
                    this.value = '';
                    $(this).parent().siblings('.error-message').text(`Discount amount must not be less than 0`);
                    error = false;
                } else if (this.value > grandTotal) {
                    $(this).parent().siblings('.error-message').text(`Discount amount must not be greater than Total Price`);
                    error = true;
                } else {
                    $(this).parent().siblings('.error-message').empty();
                    error = false;
                }
                calculateGrandTotal();
            });


            $(".productTable").on('input', '.quantity', function() {

                let oldQuantity = Number($(this).data('qty') ?? 0);
                let saleQuantity = Number($(this).parents('tr').find('.sale-qty').text());
                let quantity = Number($(this).val());
                let stockQuantity = Number($(this).parents('tr').find('.stock-qty').text());

                let updateQuantity = oldQuantity - quantity;

                if (quantity <= saleQuantity && quantity <= stockQuantity) {
                    $(this).parent().siblings('.error-message').empty();
                    error = false;
                } else if ($(this).val() == '') {
                    $(this).parent().siblings('.error-message').text('This field must not be empty');
                    error = true;
                } else if (quantity > saleQuantity) {
                    $(this).parent().siblings('.error-message').text('Must not be greater than sale Qty');
                    error = true;
                } else if (!isEdit && oldQuantity + stockQuantity < quantity) {
                    $(this).parent().siblings('.error-message').text('Must not be greater than stock Qty');
                    error = true;
                } else {
                    $(this).parent().siblings('.error-message').empty();
                    error = false;
                }

                if (isEdit && updateQuantity >= 0 && updateQuantity > stockQuantity) {
                    $(this).parent().siblings('.error-message').text('You can\'t reduce more than stock quantity');
                    error = true;
                }

                if (isEdit && quantity < 1) {
                    $(this).parent().siblings('.error-message').text('Return Qty must be greater than 0');
                    error = true;
                }

                calculateProductData($(this));
            });

            function manageSubmitButton() {
                if (error) {
                    $('.submit-btn').attr('disabled', 'disabled');
                } else {
                    $('.submit-btn').removeAttr('disabled');
                }
            }


            $(".productTable").on('input', '.sale_return_price', function() {
                calculateProductData($(this).data('id'));
            });

            function calculateProductData($this) {
                let qty = $this.val() ?? 0;
                let salesReturnPrice = $this.parents('tr').find('.sale-price').text();
                let total = qty * salesReturnPrice;
                $this.parents('tr').find('.total-price').text(total.toFixed(2))
                calculateGrandTotal();
            }

            function calculateGrandTotal() {
                let total = 0;

                $('.total-price').each(function(index, element) {
                    total = total + parseFloat($(element).text().replace(',', ''));
                });

                let discount = $("[name=discount]").val() * 1;
                $('.grand-total').text(total.toFixed(2))

                let returnAmount = total - discount;
                $(".return_amount").val(returnAmount.toFixed(2));
                let paidAmount = Number($('[name=paid_amount]').val());

                $('.due_amount').val(returnAmount - paidAmount);
                manageSubmitButton();
            }
        })(jQuery);
    </script>
@endpush
