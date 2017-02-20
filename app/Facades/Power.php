<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Power extends Facade {
    protected static function getFacadeAccessor() {
        return 'Power';
    }
}