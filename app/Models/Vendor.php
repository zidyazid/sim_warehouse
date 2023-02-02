<?php

namespace App\Models;

use App\Models\itemin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_name', 'vendor_address', 'vendor_contact'];

    /**
     * Get all of the item for the Vendor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function item(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get all of the itemin for the Vendor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemin(): HasMany
    {
        return $this->hasMany(itemin::class);
    }
}
