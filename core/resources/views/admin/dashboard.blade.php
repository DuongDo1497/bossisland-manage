@extends('admin.layouts.app')
@section('panel')
    @if (@json_decode($general->system_info)->version > systemDetails()['version'])
        <div class="row">
            <div class="col-md-12">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">
                        <h3 class="card-title">@lang('New Version Available') <button class="btn btn--dark float-end">@lang('Version')
                                {{ json_decode($general->system_info)->version }}</button> </h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                        <p>
                            <pre class="f-size--24">{{ json_decode($general->system_info)->details }}</pre>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (@json_decode($general->system_info)->message)
        <div class="row">
            @foreach (json_decode($general->system_info)->message as $msg)
                <div class="col-md-12">
                    <div class="alert border border--primary" role="alert">
                        <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                        <p class="alert__message">@php echo $msg; @endphp</p>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row gy-4 mb-30">
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-shopping-cart overlay-icon text--primary"></i>
                <div class="widget-two__icon b-radius--5 bg--primary">
                    <i class="las la-shopping-cart"></i>
                </div>
                <div class="widget-two__content">
                    <h3> {{ $general->cur_sym }}{{ showAmount($widget['total_sale']) }}</h3>
                    <p>@lang('Sales')</p>
                </div>
                <a href="{{ route('admin.sale.index') }}" class="widget-two__btn border border--primary btn-outline--primary">@lang('View All')</a>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="fas la-undo overlay-icon text--warning"></i>
                <div class="widget-two__icon b-radius--5 bg--warning">
                    <i class="las la-undo"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $general->cur_sym }}{{ showAmount($widget['total_sale_return']) }}</h3>
                    <p>@lang('Sales Return')</p>
                </div>
                <a href="{{ route('admin.sale.return.index') }}" class="widget-two__btn border border--warning btn-outline--warning">@lang('View All')</a>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-shopping-bag overlay-icon text--success"></i>
                <div class="widget-two__icon b-radius--5 bg--success">
                    <i class="las la-shopping-bag"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $general->cur_sym }}{{ showAmount($widget['total_purchase']) }}</h3>
                    <p>@lang('Purchases')</p>
                </div>
                <a href="{{ route('admin.purchase.index') }}" class="widget-two__btn border border--success btn-outline--success">@lang('View All')</a>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-share  overlay-icon text--danger"></i>
                <div class="widget-two__icon b-radius--5 bg--danger">
                    <i class="las la-share"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $general->cur_sym }}{{ showAmount($widget['total_purchase_return']) }}</h3>
                    <p>@lang('Purchases Return')</p>
                </div>
                <a href="{{ route('admin.purchase.return.index') }}" class="widget-two__btn border border--danger btn-outline--danger">@lang('View All')</a>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->


    <div class="row gy-4 mb-30">
        <div class="col-xxl-7">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h5>@lang('Monthly Purchase & Sales Report') (@lang('Last 12 Month'))</h5>
            </div>
            <div class="card">
                <div class="card-body">
                    <div id="apex-bar-chart"> </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-5">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h5>@lang('Top Selling Products')</h5>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                                <tr>
                                    <th>@lang('Product')</th>
                                    <th>@lang('SKU')</th>
                                    <th>@lang('Quantity')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topSellingProducts as $product)
                                    <tr>

                                        <td data-label="@lang('Product')">
                                            {{ $loop->iteration }}. &nbsp;
                                            <a class="text--dark" href="{{ route('admin.product.edit', $product->id) }}">{{ strLimit(__($product->name), 20) }}</a>
                                        </td>
                                        <td data-label="@lang('Quantity')">{{ $product->sku }} </td>
                                        <td data-label="@lang('Quantity')">{{ $product->total_sale }} {{ $product->unit->name }} </td>
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
            </div>
        </div>
    </div>

    <div class="row gy-4 mb-30">
        <div class="col-xl-6">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h5>@lang('Product Alert Items') </h5>
                <a href="{{ route('admin.product.alert') }}" class="btn btn-sm btn-outline--primary">@lang('View All')</a>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                                <tr>
                                    <th>@lang('Product')</th>
                                    <th>@lang('Warehouse')</th>
                                    <th>@lang('Alert')</th>
                                    <th>@lang('Stock')</th>
                                    <th>@lang('Unit')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($widget['alertProductsQty'] as $alertQty)
                                    <tr>
                                        <td class="fw-bold"> {{ $alertQty->name }} </td>
                                        <td> {{ $alertQty->warehouse_name }} </td>
                                        <td>
                                            <span class="bg--warning px-2 rounded">
                                                {{ $alertQty->alert_quantity }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="bg--danger px-2 rounded">
                                                {{ $alertQty->quantity }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $alertQty->unit_name }}
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
            </div>
        </div>

        <div class="col-xl-6">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h5>@lang('Latest Sale Returns') </h5>
                <a href="{{ route('admin.sale.return.index') }}" class="btn btn-sm btn-outline--primary">@lang('View All')</a>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Invoice No.') </th>
                                    <th>@lang('Customer')</th>
                                    <th>@lang('Amount')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($saleReturns as $return)
                                    <tr>
                                        <td>
                                            {{ showDateTime($return->return_date, 'd M, Y') }}
                                        </td>

                                        <td>
                                            <a class="text--dark" href="{{ route('admin.sale.return.edit', $return->id) }}">{{ $return->sale->invoice_no }}</a>
                                        </td>

                                        <td>
                                            {{ $return->customer->name }}
                                        </td>

                                        <td>
                                            {{ $general->cur_sym . showAmount($return->payable_amount) }}
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
            </div>
        </div>


    </div>


    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two style--two box--shadow2 b-radius--5 bg--1">
                <i class="las la-layer-group overlay-icon text--white"></i>
                <div class="widget-two__icon b-radius--5 bg--primary">
                    <i class="lab la-buffer"></i>
                </div>
                <div class="widget-two__content">
                    <h3 class="text-white">{{ $widget['total_category'] }}</h3>
                    <p class="text-white">@lang('Categories')</p>
                </div>
                <a href="{{ route('admin.product.category.index') }}" class="widget-two__btn">@lang('View All')</a>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two style--two box--shadow2 b-radius--5 bg--primary">
                <i class="lab la-product-hunt overlay-icon text--white"></i>
                <div class="widget-two__icon b-radius--5 bg--primary">
                    <i class="lab la-product-hunt"></i>
                </div>
                <div class="widget-two__content">
                    <h3 class="text-white">{{ $widget['total_product'] }}</h3>
                    <p class="text-white">@lang('Products')</p>
                </div>
                <a href="{{ route('admin.product.index') }}" class="widget-two__btn">@lang('View All')</a>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--18 has-link box--shadow2">
                <a href="{{ route('admin.supplier.index') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-user-friends f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('Supplier')</span>
                            <h2 class="text-white">{{ $widget['total_supplier'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--12 has-link overflow-hidden box--shadow2">
                <a href="{{ route('admin.customer.index') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-users f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('Customers')</span>
                            <h2 class="text-white">{{ $widget['total_customers'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

@endsection

@push('style')
    <style>
        .widget-two__btn {
            right: 15px !important;
        }
    </style>
@endpush




@push('script')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>

    <script>
        "use strict";
        window.onload = function() {

            var options = {
                series: [{
                        name: 'Total Purchase',
                        data: @json($purchaseData)
                    },
                    {
                        name: 'Total Purchase Return',
                        data: @json($purchaseReturnData)
                    },
                    {
                        name: 'Total Sale',
                        data: @json($saleData)
                    },
                    {
                        name: 'Total Sale Return',
                        data: @json($saleReturnData)
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 417,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '50%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: @json($months)
                },
                yaxis: {
                    title: {
                        text: "{{ $general->cur_text }}",
                        style: {
                            color: '#7c97bb'
                        }
                    }
                },
                grid: {
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false
                        }
                    },
                },
                fill: {
                    colors: ['#008ffb', '#fbb225', '#00e396', '#ea5455'],
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return `{{ $general->cur_sym }} ${val}`
                        }
                    }
                },
                legend: {
                    markers: {
                        width: 12,
                        height: 12,
                        strokeWidth: 0,
                        strokeColor: '#fff',
                        fillColors: ['#008ffb', '#fbb225', '#00e396', '#ea5455'],
                        radius: 12,
                    },
                }
            };

            var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
            chart.render();
        }
    </script>
@endpush
