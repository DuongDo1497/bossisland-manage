@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-3">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="@isset($adjustment) {{ route('admin.adjustment.update', @$adjustment->id) }} @else {{ route('admin.adjustment.store') }} @endisset" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Warehouse')</label>

                                    @if (@$adjustment)
                                        <select name="warehouse_id" class="form-control " required>
                                            <option value="{{ $adjustment->warehouse_id }}" selected>
                                                {{ __($adjustment->warehouse->name) }}</option>
                                        </select>
                                    @else
                                        <select name="warehouse_id" class="form-control " required>
                                            <option value="" selected disabled>@lang('Select One')</option>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}" @selected($warehouse->id == @$adjustment->warehouse_id)>
                                                    {{ __($warehouse->name) }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Date')</label>
                                    <input name="adjust_date" type="text" data-language="en" class="datepicker-here form-control bg--white" data-position='bottom left' autocomplete="off" value="{{ old(date('m/d/Y'), showDateTime(@$adjustment->retrun_date, 'm/d/Y')) }}" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group products-container position-relative">
                                    <label> @lang('Product')</label>
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
                            <div class="table-responsive table-responsive--lg">
                                <table class="productTable table border">
                                    <thead class="border bg--dark">
                                        <tr>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Current Stock')</th>
                                            <th>@lang('Stock - After Adjust')</th>
                                            <th class="qty-field">@lang('Adjust Qty') <span class="text-danger">*</span></th>
                                            <th>@lang('Type') <span class="text-danger">*</span></th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @isset($adjustment)
                                            @foreach ($adjustment->adjustmentDetails as $item)
                                                <tr data-product_id="{{ $item->product->id }}" class="product-row">
                                                    <td>
                                                        {{ $item->product->name }}
                                                        <input type="hidden" name="products[{{ $loop->index }}][product_id]" value="{{ $item->product->id }}" />
                                                    </td>

                                                    <td>
                                                        @php
                                                            $quantity = $item->product->productStock->where('warehouse_id', $adjustment->warehouse_id)->first()->quantity;
                                                        @endphp
                                                        <span class="stock-qty">{{ $quantity }}</span>
                                                        {{ $item->product->unit->name }}
                                                    </td>

                                                    <td>
                                                        <span class="after-adjust-qty">{{ $quantity }}</span>
                                                        {{ $item->product->unit->name }}
                                                    </td>

                                                    <td>

                                                        <input type="hidden" class="old-qty" value="{{ $item->quantity }}">
                                                        <input type="hidden" class="old-type" value="{{ $item->adjust_type }}">

                                                        <div class="input-group">
                                                            <input type="number" name="products[{{ $loop->index }}][quantity]" value="{{ $item->quantity }}" class="bg--white form-control quantity" data-id="{{ $item->product->id }}" data-qty="{{ $item->quantity }}" required>

                                                            <span class="input-group-text">{{ $item->product->unit->name }}</span>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <select name="products[{{ $loop->index }}][adjust_type]" class="form-control adjust-type" required>
                                                            <option value="1" @selected(1 == $item->adjust_type)>
                                                                @lang('Subtract')</option>
                                                            <option value="2" @selected(2 == $item->adjust_type)>
                                                                @lang('Add')</option>
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <button type="button" class="btn btn-outline--danger h-45 disabled max-content">
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
                            <div class="col-md-12 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Note')</label>
                                    <textarea name="note" class="form-control" required>{{ old('note', @$adjustment->note) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn--primary w-100 h-45 submit-btn">@lang('Submit')</button>
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
    <x-back route="{{ route('admin.adjustment.index') }}" />
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
            min-width: 280px;
            width: 280px
        }

        .max-content {
            width: max-content
        }
    </style>
@endpush


@push('script')
    <script>
        (function($) {
            'use strict';
            let productArray = [];

            @if (@$adjustment)
                productArray = @json($adjustment->adjustmentDetails->pluck('product_id')->toArray());
            @endif

            $(".keyword").on('input', function() {
                let data = {};
                data.keyword = $(this).val();
                data.warehouse = $("[name=warehouse_id]").find(':selected').val();
                var warehouseId = data.warehouse;

                if (data.warehouse && data.keyword) {
                    $('.products-container .error-message').empty();

                    $.ajax({
                        url: "{{ route('admin.adjustment.search.product') }}",
                        method: 'GET',
                        data: data,
                        success: function(response) {

                            var products = '';
                            $(".products").html('');
                            if (response.data.length) {

                                $.each(response.data, function(key, product) {
                                    if (product) {
                                        if (product.product_stock) {
                                            var stock = product.product_stock.find((product) => product.warehouse_id == warehouseId);

                                            products +=
                                                `<li class="products__item productItem" data-id="${product.id}" data-name="${product.name}" data-unit="${product.unit.name}" data-stock="${ stock ? stock.quantity : 0}">
                                                    <h6>${product.name}</h6><small>SKU: ${product.sku}</small>
                                                </li>`;
                                        }
                                    }
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
                    $('.products-container .error-message').text("@lang('No product found')");
                }
            });

            $('body').on('click', '.productItem', function() {
                let index = $('.product-row ').length + 1;
                var data = $(this).data();
                let productId = data.id;

                if (!productArray.includes(productId)) {
                    productArray.push(productId);

                    $(".productTable tbody").append(`
                        <tr data-product_id="${data.id}" class="product-row">
                            <td data-label="@lang('Name')">
                                ${data.name}
                                <input type="hidden" name="products[${index}][product_id]" value="${data.id}"/>
                            </td>

                            <td data-label="@lang('Current Stock')">
                                <span class="stock-qty">${data.stock}</span> ${data.unit}
                            </td>

                            <td data-label="@lang('Stock - After Adjust')">
                                <span class="after-adjust-qty"></span>
                                ${data.unit}
                                <br/>
                                <span class="text--danger error-message"></span>
                            </td>

                            <td data-label="@lang('Adjust Qty')">
                                <input type="hidden" class="old-qty" value="0">
                                <input type="hidden" class="old-type" value="1">

                                <div class="input-group">
                                    <input type="number" name="products[${index}][quantity]" value="1"  class="bg--white form-control quantity" data-id="${data.id}" required>
                                    <span class="input-group-text">${data.unit}</span>
                                </div>
                            </td>
                            <td data-label="@lang('Type')">
                                <select name="products[${index}][adjust_type]" class="form-control adjust-type " required>
                                    <option value="1" @selected(1 == request()->adjust_type)>@lang('Subtract')</option>
                                    <option value="2" @selected(2 == request()->adjust_type)>@lang('Add')</option>
                                </select>
                            </td>
                            <td data-label="@lang('Action')">
                                <button type="button" class="btn btn-outline--danger removeBtn h-45 max-content">
                                    <i class="la la-trash"></i> @lang('Remove')
                                </button>
                            </td>
                        </tr>
                    `);

                    setAdjustQuantity($(".productTable tr:last-child").find('.quantity'));

                } else {
                    let quantityField = $(`[data-product_id=${productId}]`).find('.quantity');
                    quantityField.val(Number(quantityField.val()) + 1);
                    setAdjustQuantity(quantityField);
                }

                $(".products").empty();
                $('.keyword').val("");

            });

            let error = false;

            $(".productTable").on('input', '.quantity', function() {
                if (this.value < 0) {
                    this.value = 0;
                }
                setAdjustQuantity($(this));
            });

            $(".productTable").on('change', '.adjust-type', function() {
                setAdjustQuantity($(this));
            });

            function manageSubmitButton() {
                if (error) {
                    $('.submit-btn').attr('disabled', 'disabled');
                } else {
                    $('.submit-btn').removeAttr('disabled');
                }
            }

            function setAdjustQuantity($this) {

                let parent = $this.parents('tr');
                let adjustQty = parent.find('.quantity').val() * 1;
                let oldQty = parent.find('.old-qty').val() * 1;
                let oldType = parent.find('.old-type').val() * 1;
                let type = parent.find('.adjust-type').val() * 1;

                if (oldType == type && adjustQty == oldQty) { // If same as old value
                    adjustQty = 0;
                } else {

                    if (oldType == 2 && type == 1) { // If from ADD to SUBTRACT
                        adjustQty = (adjustQty * -1) + (oldQty * -1);
                    } else if (oldType == 1 && type == 2) { // If from SUBTRACT to ADD
                        adjustQty += oldQty;
                    } else if (type == 1) {
                        adjustQty = oldQty - adjustQty;
                    } else {
                        adjustQty = adjustQty - oldQty;
                    }
                }

                let stockQty = parent.find('.stock-qty').text() * 1;
                let afterAdjustStock = stockQty + (adjustQty * 1);

                parent.find('.after-adjust-qty').text(afterAdjustStock);

                if (afterAdjustStock < 0) {

                    error = true;
                    parent.find('.after-adjust-qty').siblings('.error-message').text("You can\'t subtract, the current stock is 0")
                    parent.find('.after-adjust-qty').addClass('text--danger');
                } else {
                    error = false;
                    parent.find('.after-adjust-qty').siblings('.error-message').empty()
                    parent.find('.after-adjust-qty').removeClass('text--danger');
                }

                manageSubmitButton()
            }

            $(".productTable").on('click', '.removeBtn', function() {
                let productId = Number($(this).parents('tr').find('.product_id').val());
                let indexToRemove = productArray.indexOf(productId);
                productArray.splice(indexToRemove, 1)
                $(this).parents('tr').remove();
                calculateGrandTotal();
            });

            $('[name=warehouse_id]').on('change', function() {
                if (productArray) {
                    productArray = [];
                    $("tbody").empty();
                }
            })

        })(jQuery);
    </script>
@endpush
