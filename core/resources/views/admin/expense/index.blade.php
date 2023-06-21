@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two custom-data-table table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Reason')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expenses as $expense)
                                    <tr>
                                        <td>{{ $expenses->firstItem() + $loop->index }}</td>
                                        <td>{{ $expense->expenseType->name }}</td>
                                        <td>{{ showDateTime($expense->date_of_expense, 'd M, Y') }}</td>
                                        <td>{{ showAmount($expense->amount) }} {{ $general->cur_text }}</td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $expense }}" data-modal_title="@lang('Edit Expense Info')">
                                                <i class="la la-pencil"></i>@lang('Edit')
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
                @if ($expenses->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($expenses) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>

    <!--Add Modal -->
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Add Expense')</span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.expense.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Type')</label>
                            <select name="expense_type_id" class="form-control" required>
                                <option value="" disabled selected>@lang('Select One')</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"> {{ __($item->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>@lang('Date of Expense')</label>
                            <input name="date_of_expense" type="text" data-language="en" class="datepicker-here form-control bg--white" autocomplete="off" value="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd" required>
                            <small class="text-muted text--small"> <i class="la la-info-circle"></i> @lang('Year-Month-Date')</small>
                        </div>

                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <button class="input-group-text">{{ $general->cur_sym }}</button>
                                <input type="number" step="any" name="amount" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Note')</label>
                            <textarea name="note" class="form-control" rows="5"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form dateSearch='yes' keySearch='no' />

    <button type="button" class="btn btn-sm btn-outline--primary float-sm-end cuModalBtn" data-modal_title="@lang('Add New Expense')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush
