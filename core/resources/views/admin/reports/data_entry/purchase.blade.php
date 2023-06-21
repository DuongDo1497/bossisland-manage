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
                                    <th>@lang('Invoice No.')</th>
                                    @include('admin.reports.data_entry.partials.common_headings')
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($entries as $entry)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.purchase.edit', $entry->actionable_id) }}">{{ $entry->actionable->invoice_no }}</a>
                                        </td>
                                        @include('admin.reports.data_entry.partials.common_columns')
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>

                @if ($entries->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($entries) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection
