<?php
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => '\App\Modules\ProjectCustoms\Http\Controllers\Client',
        'prefix' => 'api/idealdog',
    ],
    function () {
        Route::get('all', 'IdealDogsController@all');
    }
);
