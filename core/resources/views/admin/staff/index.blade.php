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
                                    <th>@lang('Username')</th>
                                    <th>@lang('E-mail')</th>
                                    <th>@lang('Mobile')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($staffs as $staff)
                                    <tr>
                                        <td> {{ $staffs->firstItem() + $loop->index }} </td>
                                        <td> {{ $staff->name }} </td>
                                        <td> <span class="fw-bold">{{ $staff->username }}</span> </td>
                                        <td> {{ $staff->email }} </td>
                                        <td> +{{ $staff->mobile }} </td>
                                        <td>
                                            @php
                                                echo $staff->statusBadge;
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $staff }}" data-modal_title="@lang('Edit Staff')" data-has_status="1">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </button>

                                                <a href="{{ route('admin.staff.login', $staff->id) }}" class="btn btn-sm btn-outline--info" target="blank">
                                                    <i class="la la-sign-in-alt"></i>@lang('Login')
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
                        </table>
                        @if ($staffs->hasPages())
                            <div class="card-footer py-4">
                                @php echo  paginateLinks($staffs) @endphp
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Update Modal -->
    <div class="modal fade" id="cuModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="la la-times"></i>
                    </button>
                </div>

                <form action="{{ route('admin.staff.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <input type="text" name="name" class="form-control" autocomplete="off" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>@lang('Username')</label>
                                    <input type="text" name="username" class="form-control" autocomplete="off" value="{{ old('username') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('E-Mail')</label>
                                    <input type="email" class="form-control " name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Password')</label>
                                    <div class="input-group">
                                        <input type="text" name="password" class="form-control" value="{{ old('password') }}" required>
                                        <button type="button" class="input-group-text generatePassword">@lang('Generate')</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">@lang('Mobile')
                                        <i class="fa fa-info-circle text--primary" title="@lang('Type the mobile number including the country code. Otherwise, SMS won\'t send to that number.')">
                                        </i>
                                    </label>
                                    <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control " required>
                                </div>
                            </div>


                        </div>

                        <div class="status"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <x-search-form />
    <!-- Modal Trigger Button -->
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Staff')">
        <i class="la la-plus"></i>@lang('Add New')
    </button>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            let modal = $('#cuModal');
            let passField = modal.find('[name=password]');

            modal.on('show.bs.modal', function() {
                let title = $('.modal-title').text();
                let label = passField.parents('.form-group').find('label').first();

                if (title == 'Edit Staff') {
                    passField.removeAttr('required');
                    label.removeClass('required');
                    passField.val('');
                } else {
                    passField.val(generatePassword());
                    passField.attr('required', 'required');
                    label.addClass('required');
                }
            });

            $('.generatePassword').on('click', function() {
                passField.val(generatePassword());
            });

            function generatePassword(length = 12) {
                let charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+<>?/";
                let password = '';

                for (var i = 0, n = charset.length; i < length; ++i) {
                    password += charset.charAt(Math.floor(Math.random() * n));
                }

                return password
            }

        })(jQuery);
    </script>
@endpush
