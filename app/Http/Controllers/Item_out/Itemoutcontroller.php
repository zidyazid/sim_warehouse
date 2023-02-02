<?php

namespace App\Http\Controllers\Item_out;

use App\Models\Item;
use App\Models\itemin;
use App\Models\Vendor;
use App\Models\Itemout;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Stock;

class Itemoutcontroller extends Controller
{
    public function index()
    {
        $data['dataVendor'] = Vendor::all();
        $data['dataItem'] = Item::all();
        return view('dashboard.itemout.index', $data);
    }

    // GET DATA ITEM OUT
    public function get_data()
    {
        $data = Itemout::join('vendors', 'vendors.id', '=', 'itemouts.vendor_id')
            ->join('items', 'items.id', '=', 'itemouts.item_id')->get();

        // dd($data);

        return DataTables::of($data)->make(true);
    }

    // GET DATA ON VENDOR ID AND ITEM ID
    public function get_databy_vendor_and_item_id(Request $request)
    {
        $data = Item::where('id', $request->item_id)->where('vendor_id', $request->vendor_id)->first();
        return json_encode($data);
    }

    // GET DATA BY VENDOR
    public function getdata_by_vendor(Request $request)
    {
        $data = Item::where('vendor_id', $request->get('vendor_id'))->get();
        return json_encode($data);
    }

    // SAVE DATA ITEMS OUT
    public function store(Request $request)
    {
        // dd($getDataStok["total_stock"] - $request->qty);
        $getDataStok = Stock::where(['vendor_id' => $request->vendor_id, 'item_id' => $request->item_id])->first();
        // update data stok
        if ($getDataStok["total_stock"] == 0 || $getDataStok["total_stock"] < $request->qty) {
            # code...
            return json_encode(['statusCode' => 500, 'message' => 'Stok Tidak Mencukupi']);
        }
        $getDataStok["total_stock"] = $getDataStok["total_stock"] - $request->qty;
        $getDataStok->save();

        Itemout::create($request->all());

        return json_encode(['statusCode' => 200]);
    }
}
