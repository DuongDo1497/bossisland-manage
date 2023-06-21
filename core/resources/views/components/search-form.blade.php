@props([
    'placeholder' => 'Search...',
    'btn' => 'btn--primary',
    'dateSearch' => 'no',
    'keySearch' => 'yes',
])

<form action="" method="GET" class="d-flex gap-2">
    @if ($dateSearch == 'yes')
        <x-search-date-field />
    @endif

    @if ($keySearch == 'yes')
        <x-search-key-field placeholder="{{ $placeholder }}" btn="{{ $btn }}" />
    @endif
</form>
