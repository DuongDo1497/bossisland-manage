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
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($types as $type)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ __($type->name) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $type }}" data-modal_title="@lang('Edit Expense Type')" data-has_status="1">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </button>

                                            <button type="button" class="btn btn-sm btn-outline-danger @if ($type->expenses_count) disabled @endif confirmationBtn" data-question="@lang('Are you sure to delete this expense type?')" data-action="{{ route('admin.expense.type.delete', $type->id) }}">
                                                <i class="la la-trash"></i>@lang('Delete')
                                            </button>
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

    <!--Add Modal -->
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.expense.type.store') }}" method="POST">
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
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Expense Type')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush
