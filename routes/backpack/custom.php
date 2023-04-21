<?php

use Dachoagit\GoogleKeywordView\Controllers\Admin\LogProxyCrudController;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    // Route::crud('search', 'SearchCrudController');
    // Route::crud('result', 'ResultCrudController');
    // Route::get('search/{id}/search', [\App\Http\Controllers\Admin\SearchCrudController::class,'searchGoogle']);

    // Route::crud('proxy', 'ProxyCrudController');
    // Route::get('charts/log-proxies', 'Charts\LogProxiesChartController@response')->name('charts.log-proxies.index');
    // Route::crud('log-proxy', LogProxyCrudController::class);
    Route::get('charts/log-proxy-status', 'Charts\LogProxyStatusChartController@response')->name('charts.log-proxy-status.index');
}); // this should be the absolute last line of this file