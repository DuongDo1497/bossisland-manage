@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body">
                    <form action="">
                        <div class="row gy-4 justfi-conent-end align-items-end">
                            <div class="col-lg-4">
                                <label class="required">@lang('Filter By')</label>
                                <select class="form-control" name="type">
                                    <option value="warehouse" @selected(request()->type == 'warehouse')>@lang('Warehouse')</option>
                                    <option value="product" @selected(request()->type == 'product')>@lang('Product')</option>
                                </select>
                            </div>

                            <div class="col-lg-4">
                                <div class="warehouse-field @if (request()->product) d-none @endif">
                                    <label class="required">@lang('Warehouse')</label>
                                    <select class="form-control" name="warehouse" @if (!request()->product) d-none @endif>
                                        <option value="">@lang('Select One')</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" @selected(request()->warehouse == $warehouse->id)> {{ __($warehouse->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="product-field position-relative @if (!request()->product) d-none @endif">
                                    <label class="required">@lang('Product')</label>
                                    <select name="product" class="form-control " id="product">
                                        @if (request()->product)
                                            <option value="{{ request()->product }}"> {{ $productName }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <button type="submit" class="btn btn--primary h-45 w-100">
                                    <i class="la la-filter"></i>@lang('Filter')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- card end -->
        </div>
    </div>


    @include('admin.reports.stock.partials.by_product')
    @include('admin.reports.stock.partials.by_warehouse')
@endsection

@push('script')
    @push('script')
        <script>
            (function($) {
                "use strict";
                $('[name=type]').on('change', function() {

                    if ($(this).val() === 'warehouse') {
                        $('.warehouse-field').removeClass('d-none');
                        $('.product-field').addClass('d-none');
                        $('[name=product]').val('');
                    } else {
                        $('.warehouse-field').addClass('d-none');
                        $('.product-field').removeClass('d-none');
                        $('[name=warehouse]').val('');
                    }
                });

                $('#product').select2({
                    ajax: {
                        url: '{{ route('admin.product.list') }}',
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
                            let data = response.products.data;
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: `${item.name} (${item.sku})`,
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
                    dropdownParent: $(".product-field")
                }); //end here


            })(jQuery);
        </script>
    @endpush
@endpush
