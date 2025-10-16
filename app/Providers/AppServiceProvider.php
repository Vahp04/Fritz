<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Driver simple sin encriptación (SOLO desarrollo)
        Hash::extend('simple', function() {
            return new class {
                public function make($value, array $options = []) {
                    return $value; // Sin encriptación
                }
                
                public function check($value, $hashedValue, array $options = []) {
                    return $value === $hashedValue;
                }
                
                public function needsRehash($hashedValue, array $options = []) {
                    return false;
                }
            };
        });
    }
}