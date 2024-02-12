<?php

use App\Livewire\Form;

\Illuminate\Support\Facades\Route::get('form', Form::class);

if (app()->isLocal()) {
    Route::get('/test-database', function () {
        try {
            DB::connection()->getPdo();
            print_r('Connected successfully to: ' . DB::connection()->getDatabaseName());
        } catch (\Exception $e) {
            exit('Could not connect to the database.  Please check your configuration. Error:' . $e);
        }
    });
}

