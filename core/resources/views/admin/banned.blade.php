@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fa fa-ban fa-5x text--danger" aria-hidden="true"></i>
                    <h4 class="mt-3 text-muted">@lang('Your account is currently disabled by the Super Admin.')</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
