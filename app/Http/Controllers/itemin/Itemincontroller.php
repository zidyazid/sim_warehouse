<?php

namespace App\Http\Controllers\itemin;

use App\Models\Item;
use App\Models\Stock;
use App\Models\itemin;
use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class Itemincontroller extends Controller
{
    public function index()
    {
        $data["dataVendor"] = Vendor::all();
        $data['dataItem'] = Item::all();
        return view('dashboard.incomingitem.index', $data);
    }

    // GET DATA ITEM IN WITH QUERY DATATABLE
    public function get_data()
    {
        $data = DB::table('itemins')
            ->join('items', 'items.id', '=', 'itemins.item_id')
            ->join('vendors', 'vendors.id', '=', 'itemins.vendor_id')
            ->select('itemins.*', 'items.item_name', 'vendors.vendor_name')
            ->get();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<input type="hidden" name="csrf_delete" id="csrf_delete" value="' .
                    Session::token() . '"><button type="button" data-toggle="modal" id="btnModalEdit" data-target="#modalTambahItem" class="btn btn-warning btn-sm" data-id="' . $data->id . '">Edit</button><button type="button" id="btnDeleteItem" class="btn btn-sm btn-danger btn-delete" data-token = "' .
                    Session::token() . '" data-id = "' . $data->id . '">Hapus</button>';
            })
            ->make(true);
    }

    // INSERT PROSES
    public function store_data(Request $request)
    {
        // DEFINING VARIABLE
        $item = Item::find($request->item_id);
        $totalPrice = $item["item_price"] * $request->qty;
        $dataStock = DB::table('stocks')
            ->where('vendor_id', $request->vendor_id)
            ->where('item_id', $request->item_id)->doesntExist();
        $stock = Stock::where(['vendor_id' => $request->vendor_id, 'item_id' => $request->item_id])->get();
        // dd($stock[0]->total_stock);

        Itemin::create([
            'vendor_id' => $request->vendor_id,
            'item_id' => $request->item_id,
            'qty' => $request->qty,
            'total_price' => $totalPrice,
        ]);

        if ($dataStock) {
            # code...
            Stock::create([
                'vendor_id' => $request->vendor_id,
                'item_id' => $request->item_id,
                'total_stock' => $request->qty,
            ]);
        } else {
            $stock[0]->total_stock = $stock[0]->total_stock + $request->qty;
            $stock[0]->save();
        }

        return json_encode([
            'statusCode' => 200
        ]);
    }

    public function destroy($id)
    {
        itemin::find($id)->delete();
        return json_encode([
            'statusCode' => 200
        ]);
    }

    public function update_itemin(Request $request)
    {
        $data = Itemin::find($request->id);
        return json_encode($data);
    }

    public function get_on_vendor_and_item($vendorID, $itemID)
    {
        $data = Itemin::where(['vendor_id' => $vendorID, 'item_id' => $itemID])->first();

        return json_encode($data);
    }

    public function proses_update(Request $request)
    {
        $data = Itemin::find($request->id);
        $newTotal = ($data->total_price / $data->qty) * $request->qty;
        $stock = Stock::where(['vendor_id' => $request->vendor_id, 'item_id' => $request->item_id])->first();
        // dd(($stock->total_stock - $data->qty) + $request->qty);
        $newTotalStok = ($stock->total_stock - $data->qty) + $request->qty;

        // RUMUS TOTAL HARGA
        /**
         * total / old_qty = hasil
         * hasil * new_qty = new_total 
         */

        // RUMUS TOTAL STOCk
        /**
         * total_stock = (old_stock - itemin) + update_item_in
         */

        $stock->total_stock = $newTotalStok;
        $stock->save();

        if (!$stock) {
            return json_encode(['statusCode' => 500]);
        }

        $data->vendor_id = $request->vendor_id;
        $data->item_id = $request->item_id;
        $data->qty = $request->qty;
        $data->total_price = $newTotal;
        $data->save();

        return json_encode(['statusCode' => 200]);
    }
}
