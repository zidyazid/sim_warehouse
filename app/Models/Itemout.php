<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemout extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'item_id', 'qty', 'total_price'
    ];
}
