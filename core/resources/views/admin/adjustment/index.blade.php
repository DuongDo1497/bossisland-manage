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
                                    <th>@lang('Warehouse')</th>
                                    <th>@lang('Products')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($adjustments as $adjustment)
                                    <tr>
                                        <td>{{ $adjustments->firstItem() + $loop->index }}</td>
                                        <td>{{ $adjustment->tracking_no }}</td>
                                        <td>{{ showDateTime($adjustment->adjust_date, 'd M, Y') }}</td>
                                        <td>{{ $adjustment->warehouse->name }} </td>
                                        <td>{{ $adjustment->adjustmentDetails->count() }} </td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.adjustment.edit', $adjustment->id) }}" class="btn btn-sm btn-outline--primary ms-1"><i class="las la-pen"></i>
                                                    @lang('Edit')
                                                </a>
                                                <a class="btn btn-sm  btn-outline--info" href="{{ route('admin.adjustment.details.pdf', $adjustment->id) }}">
                                                    <i class="fa fa-download"></i> @lang('Download')
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
                @if ($adjustments->hasPages())
                    <div class="card-footer py-4">
                        @php echo  paginateLinks($adjustments) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form dateSearch='yes' />

    <a href="{{ route('admin.adjustment.create') }}" class="btn btn-outline--primary"><i class="las la-plus"></i>@lang('Add New')</a>
@endpush
