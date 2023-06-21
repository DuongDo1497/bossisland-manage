@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-3">
        <div class="col-lg-12 col-md-12 mb-30">
            <form action="@isset($transfer) {{ route('admin.transfer.update', @$transfer->id) }} @else {{ route('admin.transfer.store') }} @endisset" method="POST">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>@lang('Date')</label>
                                    <input name="transfer_date" type="text" data-language="en" class="datepicker-here form-control bg--white" data-position='bottom left' autocomplete="off" value="{{ old(date('m/d/Y'), showDateTime(@$transfer->sale_date, 'm/d/Y')) }}" required>
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">@lang('From Warehouse')</label>

                                    @if (@$transfer)
                                        <select name="from_warehouse_id" class="form-control" required>
                                            <option value="{{ $transfer->from_warehouse_id }}" selected>{{ $transfer->warehouse->name }}</option>
                                        </select>
                                    @else
                                        <select name="from_warehouse_id" class="form-control" required>
                                            <option value="" selected disabled>@lang('Select One')</option>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}" @selected($warehouse->id == @$transfer->from_warehouse_id)>
                                                    {{ __($warehouse->name) }}</option>
                                            @endforeach
                                        </select>
                                    @endif

                                    <span class="text--danger error-message"></span>
                                </div>

                            </div>


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">@lang('To Warehouse')</label>
                                    @if (@$transfer)
                                        <select name="to_warehouse_id" class="form-control" required>
                                            <option value="{{ $transfer->to_warehouse_id }}" selected>{{ $transfer->toWarehouse->name }}</option>
                                        </select>
                                    @else
                                        <select name="to_warehouse_id" class="form-control" required>
                                            <option value="" selected disabled>@lang('Select One')</option>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}" @selected($warehouse->id == @$transfer->to_warehouse_id)>
                                                    {{ __($warehouse->name) }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    <span class="text--danger error-message"></span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group products-container position-relative">
                                    <label> @lang('Product')@if (!@$transfer)
                                            <span class="text--danger">*</span>
                                        @endif </label>
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
                                            <th>@lang('Quantity')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Product data will append here after select -->

                                        <!--When Edit-->
                                        @isset($transfer)
                                            @foreach ($transfer->transferDetails as $item)
                                                <tr data-product_id="{{ $item->product->id }}" class="product-row product-row-{{ $item->product->id }}">
                                                    <td class="fw-bold">
                                                        {{ $item->product->name }}
                                                        <input type="hidden" name="products[{{ $loop->index }}][product_id]" value="{{ $item->product->id }}" />
                                                    </td>

                                                    <td>
                                                        @php
                                                            $stock = @$item->product->productStock->where('warehouse_id', $transfer->from_warehouse_id)->first()->quantity;
                                                        @endphp
                                                        <span class="stock_quantity">{{ $stock }} </span> {{ $item->product->unit->name }}
                                                    </td>

                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number" name="products[{{ $loop->index }}][quantity]" value="{{ $item->quantity }}" class="form-control quantity" data-id="{{ $item->product->id }}" data-qty="{{ $item->quantity }}" required>
                                                            <span class="input-group-text">{{ $item->product->unit->name }}</span>
                                                        </div>
                                                        <span class="error-message text--danger"></span>
                                                    </td>


                                                    <td>
                                                        <button type="button" class="btn btn-outline--danger disabled  h-45">
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

                        <div class="form-group">
                            <label>@lang('Note')</label>
                            <textarea name="note" class="form-control">{{ old('note', @$transfer->note) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn--primary w-100 h-45 submit-btn">@lang('Submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.transfer.index') }}"></x-back>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            $('[name=from_warehouse_id]').on('change', function() {
                $('.products').empty();
                $('.keyword').val('');
                let id = $(this).val();
                $('[name=to_warehouse_id]').find(`option`).show();
                let option = $('[name=to_warehouse_id]').find(`option[value=${id}]`);
                option.hide();

            }).change();


            $('[name=to_warehouse_id]').on('change', function() {
                let id = $(this).val();
                $('[name=from_warehouse_id]').find(`option`).show();
                let option = $('[name=from_warehouse_id]').find(`option[value=${id}]`);
                option.hide();
            }).change();


            let productArray = [];
            @if (@$transfer)
                productArray = @json($transfer->transferDetails->pluck('product_id')->toArray());
            @endif



            $(".keyword").on('input', function() {
                let data = {};
                data.keyword = $(this).val();
                data.from_warehouse = $("[name=from_warehouse_id]").find(':selected').val();

                $('.products-container .error-message').empty();

                if (data.from_warehouse && data.keyword) {
                    $.ajax({
                        url: "{{ route('admin.transfer.search.product') }}",
                        method: 'GET',
                        data: data,
                        success: function(response) {
                            var products = '';
                            $(".products").html('');
                            if (response.data.length) {

                                $.each(response.data, function(key, product) {
                                    var stock = product.product_stock.find((product) =>
                                        product.warehouse_id == data.from_warehouse);
                                    products +=
                                        `<li class="products__item productItem" data-id="${product.id}" data-stock="${stock.quantity}" data-name="${product.name}" data-unit="${product.unit.name}"><h6>${product.name}</h6><small>SKU: ${product.sku}</small></li>`;
                                });
                                $(".products").html(products);
                            } else {
                                $('.products-container .error-message').text("@lang('No product found')");
                            }

                            $('[name=from_warehouse_id]').parents('.form-group').find(
                                '.error-message').empty();
                        },
                    });
                } else if (!data.from_warehouse) {
                    $('[name=from_warehouse_id]').parents('.form-group').find('.error-message').text(
                        "@lang('This field is required to select product')");
                    $('[name=from_warehouse_id]').focus();
                    $(this).val('');
                } else {
                    $(".products").empty();
                    $('.products-container .error-message').text("@lang('No product found')");
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
                                ${data.name}
                                <input type="hidden" name="products[${index}][product_id]" value="${data.id}"/>
                            </td>
                            <td data-label="@lang('In Stock')">
                                    <span class="stock_quantity">${data.stock} </span>  ${data.unit}
                            </td>

                            <td data-label="@lang('Quantity')">
                                <div class="input-group">

                                    <input type="number" name="products[${index}][quantity]" value="1"  class="form-control quantity" data-id="${data.id}" required>

                                    <span class="input-group-text">${data.unit}</span>
                                </div>
                                <span class="error-message text--danger"></span>
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
                }

                $(".products").empty();
                $('.keyword').val("");

            });

            $(".productTable").on('click', '.removeBtn', function() {
                let productId = Number($(this).parents('tr').find('.product_id').val());
                let indexToRemove = productArray.indexOf(productId);
                productArray.splice(indexToRemove, 1)
                $(this).parents('tr').remove();
            });

            let error = false;
            $(".productTable").on('input', '.quantity', function() {

                var id = $(this).data('id');
                var initialQty = Number($(this).parents('tr').find('.quantity').data('qty'));
                var stockQty = Number($(this).parents('tr').find('.stock_quantity').text());
                var qty = Number($(this).val());
                var accStock = stockQty + (initialQty ? initialQty : 0);

                if (accStock < qty) {
                    $(this).parent().siblings('.error-message').text('Must not be greater than stock Qty');
                    error = true;
                } else if ($(this).val() == '') {
                    $(this).parent().siblings('.error-message').text('This field must not be empty');
                    error = true;
                } else {
                    error = false;
                    $(this).parent().siblings('.error-message').empty();
                }
                manageSubmitButton()

            });


            $('.keyword').on('input', function() {
                let toWarehouse = $('[name=to_warehouse_id]').val();
                if (!toWarehouse) {
                    error = true;
                }
                manageSubmitButton();
            })

            $('[name=to_warehouse_id]').on('change', function() {
                $(this).siblings('.error-message').empty()
                error = false;
                manageSubmitButton();
            })

            function manageSubmitButton() {
                if (error) {
                    $('.submit-btn').attr('disabled', 'disabled');
                } else {
                    $('.submit-btn').removeAttr('disabled');
                }
            }

            $('[name=from_warehouse_id]').on('change', function() {
                if (productArray) {
                    productArray = [];
                    $("tbody").empty();
                }
            })

        })(jQuery);
    </script>
@endpush
