<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'http://127.0.0.1:8000/api/loging/*',
       'http://127.0.0.1:8000/api/singing/*',
       'http://127.0.0.1:8000/api/storeCategories',
       'http://127.0.0.1:8000/api/deleteCategories/*',
       'http://127.0.0.1:8000/api/updateCategory/*',
      'http://127.0.0.1:8000/api/addFavourite/*',
      'http://127.0.0.1:8000/api/addBooking/*',
      'http://127.0.0.1:8000/api/deleteBooking/*',
      'http://127.0.0.1:8000/api/deleteFavourite/*',



    ];
}
