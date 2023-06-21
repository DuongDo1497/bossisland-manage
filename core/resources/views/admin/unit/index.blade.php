@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Prodcuts')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($units as $unit)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $unit->name }}</td>
                                        <td>{{ $unit->products_count }}</td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $unit }}" data-modal_title="@lang('Update Unit')" data-has_status="1">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </button>

                                                <button type="button" class="btn btn-sm btn-outline-danger @if ($unit->products_count) disabled @endif confirmationBtn" data-question="@lang('Are you sure to delete this unit?')" data-action="{{ route('admin.product.unit.delete', $unit->id) }}">
                                                    <i class="la la-trash"></i>@lang('Delete')
                                                </button>

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
            </div><!-- card end -->
        </div>
    </div>

    <!--Create & Update Modal -->
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Add Unit')</span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.product.unit.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Unit')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush
