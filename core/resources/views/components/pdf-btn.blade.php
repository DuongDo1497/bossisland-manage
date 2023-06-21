@props(['buttonName' => 'PDF'])
@if (isSuperAdmin())
    <a class="btn btn-outline--dark" href="{{ request()->fullUrlWithQuery(['print' => true]) }}"><i class="la la-download"></i> {{ __($buttonName) }}</a>
@endif
