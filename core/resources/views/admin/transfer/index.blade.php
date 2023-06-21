@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">

                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Tracking No.')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('From')</th>
                                    <th>@lang('To')</th>
                                    <th>@lang('Products')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($transfers as $transfer)
                                    <tr>
                                        <td>{{ $transfers->firstItem() + $loop->index }}</td>
                                        <td>{{ $transfer->tracking_no }} </td>
                                        <td>{{ showDateTime($transfer->transfer_date, 'd M, Y') }}</td>
                                        <td>{{ $transfer->warehouse->name }} </td>
                                        <td>{{ $transfer->toWarehouse->name }} </td>
                                        <td>{{ $transfer->transfer_details_count }}</td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.transfer.edit', $transfer->id) }}" class="btn btn-sm btn-outline--primary ms-1 editBtn"><i class="la la-pen"></i> @lang('Edit')
                                                </a>
                                                <a class="btn btn-sm  btn-outline--info" href="{{ route('admin.transfer.pdf', $transfer->id) }}">
                                                    <i class="la la-download"></i> @lang('Download')
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
                @if ($transfers->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($transfers) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form dateSearch='yes' />
    <a href="{{ route('admin.transfer.create') }}" class="btn btn-outline--primary h-45">
        <i class="la la-plus"></i>@lang('Add New')
    </a>
@endpush
