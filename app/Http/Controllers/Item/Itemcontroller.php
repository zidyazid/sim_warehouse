<?php

namespace App\Http\Controllers\Item;

use App\Models\Item;
use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class Itemcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['dataVendor'] = Vendor::all();
        return view('dashboard.admin.item.index', $data);
    }

    public function get_on_vendor_and_item($vendorID, $itemID)
    {
        // dd($vendorID, $itemID);
        $data = Item::where(['vendor_id' => $vendorID, 'id' => $itemID])->first();

        return json_encode($data);
    }

    // GET ALL ITEM DATA
    public function get_data()
    {
        $data = Item::all();
        return DataTables::of($data)->addColumn('action', function ($data) {
            return '<input type="hidden" name="csrf_delete" id="csrf_delete" value="' .
                Session::token() . '"><button data-toggle="modal" data-id="' . $data->id . '" data-target="#exampleModal" id="btnDetail" class="btn btn-info btn-sm">Detail</button><button type="button" id="btnDeleteItem" class="btn btn-sm btn-danger btn-delete" data-token = "' .
                Session::token() . '" data-id = "' . $data->id . '">Hapus</button>';
        })->make(true);
    }

    // GET DATA BY ID
    public function get_by_id(Request $request)
    {
        $data = Item::find($request->id);
        return json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        Item::create([
            'vendor_id' => $request->vendor_id,
            'item_code' => 'ITM' . Str::random(10),
            'item_name' => $request->item_name,
            'item_desc' => $request->item_desc,
            'item_price' => $request->item_price,
        ]);

        return json_encode([
            'statusCode' => 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $item = Item::find($request->id);
        $item->vendor_id = $request->vendor_id;
        $item->item_name = $request->item_name;
        $item->item_desc = $request->item_desc;
        $item->item_price = $request->item_price;

        $item->save();

        if (!$item) {
            return json_encode(['statusCode' => 500]);
        }
        return json_encode(['statusCode' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
