@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>

                                    <th>@lang('SKU') </th>
                                    <th>@lang('Name') </th>
                                    <th>@lang('Warehouse')</th>
                                    <th>@lang('Alert Qty')</th>
                                    <th>@lang('Current Stock')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>
                                            {{ $product->sku }}
                                        </td>

                                        <td>
                                            <span>{{ __($product->name) }}</span>
                                        </td>

                                        <td>{{ $product->warehouse_name }}</td>

                                        <td>
                                            <span class="">{{ $product->alert_quantity }} {{ $product->unit_name }}</span>
                                        </td>
                                        <td>
                                            <span class="">{{ $product->quantity }} {{ $product->unit_name }}</span>
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
                @if ($products->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($products) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
@endpush
