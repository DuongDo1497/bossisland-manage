@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-3">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="@isset($sale) {{ route('admin.sale.update', @$sale->id) }} @else {{ route('admin.sale.store') }} @endisset" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Invoice No.')</label>
                                    <div class="input-group">
                                        <input type="text" name="invoice_no" value="@if (@$sale) {{ @$sale->invoice_no }} @else {{ $invoiceNumber }} @endif" class="form-control" required readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group" id="customer-wrapper">
                                    <label> @lang('Customer')</label>
                                    <select name="customer_id" class="form-control " id="customer" required>
                                        @if (isset($sale))
                                            <option value="{{ $sale->customer_id }}" selected>
                                                {{ __($sale->customer->name) . ' +' . $sale->customer->mobile }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Date')</label>
                                    <input name="sale_date" type="text" data-language="en" class="datepicker-here form-control bg--white" data-position='bottom left' autocomplete="off" value="{{ old(date('m/d/Y'), showDateTime(@$sale->sale_date, 'm/d/Y')) }}" required>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Warehouse')</label>
                                    @if (@$sale)
                                        <select name="warehouse_id" class="form-control " required>
                                            <option value="{{ $sale->warehouse_id }}" selected>
                                                {{ __($sale->warehouse->name) }}</option>
                                        </select>
                                    @else
                                        <select name="warehouse_id" class="form-control " required>
                                            <option value="" selected disabled>@lang('Select One')</option>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}" @selected($warehouse->id == @$sale->warehouse_id)>
                                                    {{ __($warehouse->name) }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group products-container position-relative">
                                    <label> @lang('Product')<span class="text--danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="las la-search"></i></span>
                                        <input type="search" class="form-control keyword" placeholder="@lang('Product Name or SKU')">
                                    </div>
                                    <ul class="products">
                                        <!-- Product data will append here after search -->
                                    </ul>
                                    <span class="text--danger error-message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="table-responsive">
                                <table class="productTable table border">
                                    <thead class="border bg--dark">
                                        <tr>
                                            <th>@lang('Name')</th>
                                            <th>@lang('In Stock')</th>
                                            <th>@lang('Quantity')<span class="text--danger">*</span></th>
                                            <th>@lang('Price')<span class="text--danger">*</span></th>
                                            <th>@lang('Total')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Product data will append here after select -->

                                        <!--When Edit-->
                                        @isset($sale)
                                            @foreach ($sale->saleDetails as $item)
                                                <tr data-product_id="{{ $item->product->id }}" class="product-row product-row-{{ $item->product->id }}">

                                                    <td class="fw-bold">
                                                        <input type="text" class="form-control" value="{{ $item->product->name }}" readonly required>
                                                        <input type="hidden" name="products[{{ $loop->index }}][product_id]" value="{{ $item->product->id }}" />
                                                    </td>

                                                    <td class="fw-bold">
                                                        @php
                                                            $stock = @$item->product->productStock->where('warehouse_id', $sale->warehouse_id)->first()->quantity;
                                                        @endphp
                                                        <input type="hidden" name="products[{{ $loop->index }}][stock_quantity]" value="{{ $stock }}" class="form-control stock_quantity" data-id="{{ $item->product->id }}" readonly required>

                                                        <div class="input-group">
                                                            <input type="number" name="products[{{ $loop->index }}][stock_quantity]" value="{{ $stock }}" class="form-control stock_quantity" data-id="{{ $item->product->id }}" readonly required>
                                                            <span class="input-group-text">{{ $item->product->unit->name }}</span>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number" name="products[{{ $loop->index }}][quantity]" value="{{ $item->quantity }}" class="form-control quantity" data-id="{{ $item->product->id }}" data-qty="{{ $item->quantity }}" required>
                                                            <span class="input-group-text">{{ $item->product->unit->name }}</span>
                                                        </div>
                                                        <span class="error-message text--danger"></span>
                                                    </td>

                                                    <td>
                                                        <div class="input-group">
                                                            <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                            <input type="text" name="products[{{ $loop->index }}][price]" class="form-control sales_price" data-id="{{ $item->product->id }}" value="{{ $item->price }}" step="any" required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                            <input type="number" value="{{ $item->price * $item->quantity }}" class="form-control total" readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-outline--danger disabled h-45">
                                                            <i class="la la-trash"></i> @lang('Remove')
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Note')</label>
                                    <textarea name="note" class="form-control">{{ old('note', @$sale->note) }}</textarea>
                                </div>

                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label> @lang('Total Price')</label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                <input type="number" class="form-control total_price" value="{{ @$sale->total_price }}" required readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label> @lang('Discount')</label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                <input type="number" step="any" name="discount" class="form-control" value="{{ old('discount', getAmount(@$sale->discount_amount)) }}">
                                            </div>
                                            <span class="error-message text--danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>@lang('Receivable Amount')</label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                <input type="number" class="form-control receivable_amount" value="{{ getAmount(@$sale->receivable_amount) }}" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    @isset($sale)
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>@lang('Received Amount')</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                    <input type="number" name="received_amountreceived_amount" class="form-control" value="{{ getAmount(@$sale->received_amount) }}" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>@lang('Due Amount')</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                    <input type="number" class="form-control due_amount" value="{{ getAmount(@$sale->due_amount) }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endisset

                                </div>
                            </div>
                        </div>

                        @if (isset($sale) && $sale->return_status == 1)
                            <div class="alert alert-danger p-3 d-flex flex-column" role="alert">
                                <h4 class="text--danger text-center"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> @lang('Some products has returned from this sale')</h4>

                                <p class="text--danger text-center">
                                    @lang('You can\'t edit a sale after return any quantity from it.')
                                    <a href="{{ route('admin.sale.return.edit', $sale->saleReturn->id) }}" class="text--primary text-decoration-underline">@lang('View Return Details')</a>
                                </p>
                            </div>
                        @endif

                        <button type="submit" class="btn btn--primary w-100 h-45 submit-btn" @if (isset($sale) && $sale->return_status == 1) disabled @endif>@lang('Submit')</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SW Notification Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="cookieModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cookieModalLabel">@lang('Warning!')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">

                    <i class="la la-4x la-info-circle text--warning" aria-hidden="true"></i>

                    <h6>@lang('Please select a warehouse before selecting product.')</h6>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.sale.index') }}"></x-back>
@endpush

@push('style')
    <style>
        #customer-wrapper {
            position: relative;
        }
    </style>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';


            $('#customer').select2({
                ajax: {
                    url: '{{ route('admin.sale.search.customer') }}',
                    type: "get",
                    dataType: 'json',
                    delay: 1000,
                    data: function(params) {
                        return {
                            search: params.term,
                            page: params.page, // Page number, page breaks
                        };
                    },
                    processResults: function(response, params) {
                        params.page = params.page || 1;
                        let data = response.customers.data;
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name + ' +' + item.mobile,
                                    id: item.id
                                }
                            }),
                            pagination: {
                                more: response.more
                            }
                        };
                    },
                    cache: false
                },
                dropdownParent: $("#customer-wrapper")
            }); //end here



            let productArray = [];

            @if (@$sale)
                productArray = @json($sale->saleDetails->pluck('product_id')->toArray());
            @endif

            calculateGrandTotal();

            $(".keyword").on('input', function() {
                $('.products-container .error-message').empty();
                let data = {};
                data.keyword = $(this).val();
                data.warehouse = $("[name=warehouse_id]").find(':selected').val();
                var warehouseId = data.warehouse;

                if (data.warehouse && data.keyword) {
                    $.ajax({
                        url: "{{ route('admin.sale.search.product') }}",
                        method: 'GET',
                        data: data,
                        success: function(response) {
                            var products = '';
                            $(".products").html('');

                            if (response.data.length) {
                                $.each(response.data, function(key, product) {

                                    var stock = product.product_stock.find((e) => e
                                        .warehouse_id == warehouseId);

                                    products +=
                                        `<li class="products__item productItem" data-stock="${stock.quantity}" data-id="${product.id}" data-name="${product.name}" data-unit="${product.unit.name}">
                                        <h6>${product.name}</h6>
                                        <small>SKU: ${product.sku}</small>
                                    </li>`;
                                });
                            } else {
                                $('.products-container .error-message').text("@lang('No product found')");
                            }

                            $(".products").html(products);
                        },
                    });
                } else if (!data.warehouse) {
                    $('#warningModal').modal('show');
                    $(this).val('');
                } else {
                    $(".products").empty();
                    $('.products-container .error-message').empty();
                }
            });

            $('body').on('click', '.productItem', function() {
                let index = $('.product-row ').length + 1;

                $(".no-data").addClass('d-none');
                var data = $(this).data();


                let productId = data.id;

                if (!productArray.includes(productId)) {
                    productArray.push(productId);

                    $(".productTable tbody").append(`
                        <tr data-product_id="${data.id}" class="product-row product-row-${data.id}">
                            <td data-label="@lang('Name')" class="fw-bold">
                                <input type="text" class="form-control" value="${data.name}" readonly required>
                                <input type="hidden" class="product_id" name="products[${index}][product_id]" value="${data.id}"/>
                            </td>

                            <td data-label="@lang('In Stock')">
                                <div class="input-group">
                                    <input type="number" name="products[${index}][stock_quantity]" value="${data.stock}"  class="form-control stock_quantity" data-id="${data.id}" readonly required>
                                    <span class="input-group-text">${data.unit}</span>
                                </div>
                            </td>

                            <td data-label="@lang('Quantity')">
                                <div class="input-group">
                                    <input type="number" name="products[${index}][quantity]" value="1"  class="form-control quantity" data-id="${data.id}" required>
                                    <span class="input-group-text">${data.unit}</span>
                                </div>
                                <span class="error-message text--danger"></span>
                            </td>
                            <td data-label="@lang('Price')">
                                <div class="input-group">
                                    <span class="input-group-text">{{ $general->cur_sym }}</span>
                                    <input type="number" name="products[${index}][price]" class="form-control sales_price" data-id="${data.id}" value="0" required>
                                </div>
                            </td>
                            <td data-label="@lang('Total')">
                                <div class="input-group">
                                    <span class="input-group-text">{{ $general->cur_sym }}</span>
                                    <input type="number" value="0" class="form-control total" readonly>
                                </div>
                            </td>
                            <td data-label="@lang('Action')">
                                <button type="button" class="btn btn-outline--danger removeBtn h-45" >
                                    <i class="la la-trash"></i> @lang('Remove')
                                </button>
                            </td>
                        </tr>
                    `);

                } else {
                    let quantityField = $(`[data-product_id=${productId}]`).find('.quantity');
                    quantityField.val(Number(quantityField.val()) + 1);

                    calculateProductData(productId)
                }

                $(".products").empty();
                $('.keyword').val("");


            });

            // Remove the product row from table
            $(".productTable").on('click', '.removeBtn', function() {
                let productId = Number($(this).parents('tr').find('.product_id').val());
                let indexToRemove = productArray.indexOf(productId);
                productArray.splice(indexToRemove, 1)
                $(this).parents('tr').remove();
                calculateGrandTotal();
            });

            let error = false;


            $(".productTable").on('input', '.quantity', function() {

                var id = $(this).data('id');
                var initialQty = Number($(this).parents('tr').find('.quantity').data('qty'));
                var stockQty = Number($(this).parents('tr').find('.stock_quantity').val());
                var qty = Number($(this).val());

                var accStock = stockQty + (initialQty ? initialQty : 0);

                if (accStock < qty) {
                    error = true;
                    $(this).parent().siblings('.error-message').text('Must not be greater than stock Qty');
                } else if ($(this).val() == '') {
                    $(this).parent().siblings('.error-message').text('This field must not be empty');
                    error = true;
                } else {
                    calculateProductData(id);
                    error = false;
                    $(this).parent().siblings('.error-message').empty();
                }
                manageSubmitButton();
            });


            $(".productTable").on('input', '.sales_price', function() {
                calculateProductData($(this).data('id'));
            });

            $("[name=discount]").on('input', function() {
                let totalPrice = $('.total_price').val() * 1;
                if (this.value < 0) {
                    this.value = '';
                    $(this).parent().siblings('.error-message').text(`Discount amount must not be less than 0`);
                    error = true;
                } else if (this.value > totalPrice) {
                    $(this).parent().siblings('.error-message').text(
                        `Discount amount must not be greater than total price`);
                    error = true;
                } else {
                    $(this).parent().siblings('.error-message').empty();
                    error = false;
                }
                manageSubmitButton();
                calculateGrandTotal();
            });


            function manageSubmitButton() {
                if (error) {
                    $('.submit-btn').attr('disabled', 'disabled');
                } else {
                    $('.submit-btn').removeAttr('disabled');
                }
            }

            function calculateProductData(id) {
                var qty = parseFloat($(".productTable .product-row-" + id + " .quantity").val() * 1);
                var salePrice = parseFloat($(".productTable .product-row-" + id + " .sales_price").val() * 1);
                var total = qty * salePrice;
                $(".productTable .product-row-" + id + "  .total").val(total.toFixed(2))
                calculateGrandTotal();
            }

            $('[name=received_amount]').on('input', function() {
                calculateGrandTotal();
                let payableAmount = Number($('.receivable_amount').val());
                let payingAmount = Number($(this).val());


                if (payableAmount < payingAmount) {
                    $(this).val(payableAmount);
                    $(".due_amount").val(0);
                }
            });



            function calculateGrandTotal() {
                var total = 0;
                $(".productTable .total").each(function(index, element) {
                    total = total + parseFloat($(element).val());
                });

                var discount = parseFloat($("[name=discount]").val() * 1);
                $(".total_price").val(total.toFixed(2));
                var payableAmount = total - discount;

                $(".receivable_amount").val(payableAmount.toFixed(2));
                let payingAmount = $('[name=received_amountreceived_amount]').val();
                $(".due_amount").val(payableAmount - payingAmount);
            }


            $('[name=warehouse_id]').on('change', function() {
                if (productArray) {
                    productArray = [];
                    $("tbody").empty();
                }
            })


        })(jQuery);
    </script>
@endpush
