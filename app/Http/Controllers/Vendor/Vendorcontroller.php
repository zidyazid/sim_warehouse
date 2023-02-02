<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Item;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Vendorcontroller extends Controller
{
    public function get_data_on_id(Request $request)
    {
        $data = Item::where('vendor_id', $request->get('vendor_id'))->get();
        return json_encode($data);
    }
}
