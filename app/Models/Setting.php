<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'shipping_charges',
        'tax_charges',
        'handling_charges',
    ];
}