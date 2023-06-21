@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Name') | @lang('SKU') </th>
                                    <th>@lang('Category') | @lang('Brand')</th>
                                    <th>@lang('Stock') </th>
                                    <th>@lang('Total Sale') | @lang('Alert Qty')</th>
                                    <th>@lang('Unit')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>
                                            <img src="{{ getImage(getFilePath('product') . '/' . $product->image, getFileSize('product')) }}">
                                        </td>

                                        <td class="long-text">
                                            <span class="fw-bold text--primary">{{ __($product->name) }}</span>
                                            <br>
                                            <span class="text--small ">{{ $product->sku }} </span>
                                        </td>

                                        <td>
                                            {{ __($product->category->name) }}
                                            <br>
                                            <span class="text--primary">{{ $product->brand->name }}</span>
                                        </td>

                                        <td>
                                            {{ $product->totalInStock() }}
                                        </td>

                                        <td>
                                            {{ $product->totalSale() }}
                                            <br>
                                            <span class="badge badge--warning">{{ $product->alert_quantity }}</span>
                                        </td>

                                        <td> {{ $product->unit->name }}</td>

                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-outline--primary ms-1 editBtn"><i class="las la-pen"></i> @lang('Edit')</a>
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
                @if ($products->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($products) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Name or SKU"></x-search-form>
    <a href="{{ route('admin.product.create') }}" class="btn btn-outline--primary">
        <i class="la la-plus"></i>@lang('Add New')
    </a>
@endpush
