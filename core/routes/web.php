<?php

use Illuminate\Support\Facades\Route;



Route::get('/test', function ($lastNumber = 'S-0') {
    $prefix         = 'S-';
    $number         = str_replace($prefix, '', $lastNumber) + 1;
    $lengthOfNumber = strlen($number);
    $numberOfZeros  = 6 - $lengthOfNumber;
    $totalLength    = $numberOfZeros + $lengthOfNumber;
    $invoiceNumber  = str_pad($number, $totalLength, '0', STR_PAD_LEFT);
    return $prefix  = 'S-' . $invoiceNumber;
});





Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::controller('SiteController')->group(function () {
    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');
});


Route::get('/', function () {
    return to_route('admin.dashboard');
})->name('home');
