<?php

namespace App\Http\Controllers\Admin;

use App\Models\itemin;
use App\Models\Vendor;
use App\Models\Itemout;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class Admincontroller extends Controller
{
    public function index()
    {
        // NOTE: hitung jumlah barang masuk
        $data['barangMasuk'] = itemin::count();
        // NOTE: hitung jumlah barang keluar
        $data['barangKeluar'] = Itemout::count();
        // NOTE: hitung total barang keluar berdasarkan bulan
        $totalOutByMonth = Itemout::select(
            DB::raw('count(total_price) total'),
            DB::raw('MONTH(created_at) month'),
        )
            ->groupBy('month')
            ->get();

        $totalInByMonth = itemin::select(
            DB::raw('count(total_price) total'),
            DB::raw('MONTH(created_at) month'),
        )
            ->groupBy('month')
            ->get();


        $arrayLenght = count($totalOutByMonth);

        $totalOut = [];
        for ($i = 0; $i < $arrayLenght; $i++) {
            $totalOut[] = $totalOutByMonth[$i]->total;
        }

        $data['totalOut'] = $totalOut;

        $arrayLenght = count($totalInByMonth);

        $totalIn = [];
        for ($i = 0; $i < $arrayLenght; $i++) {
            $totalIn[] = $totalInByMonth[$i]->total;
        }

        $data['totalIn'] = $totalIn;

        return view('dashboard.admin.index', $data,);
    }

    // --------------------------------------------------------------- //
    // -----------------------All ABOUT VENDOR------------------------ //
    // --------------------------------------------------------------- //

    public function vendor_view()
    {
        return view('dashboard.admin.vendor.index');
    }

    public function detail_vendor($id)
    {
        $data['detailVendor'] = Vendor::find($id);
        return view('dashboard.admin.vendor.detail', $data);
    }

    // QUERY DATATABLE

    public function query_vendor()
    {
        $data = Vendor::get();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<input type="hidden" name="csrf_delete" id="csrf_delete" value="' . Session::token() . '">
                <button type="button" class="btn btn-warning btn-sm mb-3" id="btnModalUpdate" data-toggle="modal" data-id="' . $data->id . '" data-target="#modalTambah">
                        Ubah Data
                </button>
                <button type="button" id="btnDelete" class="btn btn-sm btn-danger btn-delete" data-token = "' . Session::token() . '" data-id = "' . $data->id . '">Hapus</button>';
            })
            ->make(true);
        // return DataTables::of($data)
        //     ->addColumn('action', function ($data) {
        //         return '<input type="hidden" name="csrf_delete" id="csrf_delete" value="' . Session::token() . '"><a href="' . route('vendor.detail', $data->id) . '" class="btn btn-info btn-sm">Detail</a><button type="button" id="btnDelete" class="btn btn-sm btn-danger btn-delete" data-token = "' . Session::token() . '" data-id = "' . $data->id . '">Hapus</button>';
        //     })
        //     ->make(true);
    }

    // QUERY UPDATE

    public function update(Request $request)
    {
        $vendor = Vendor::find($request->id);
        // kembalikan data kepada ajax dalam bentuk json
        return json_encode($vendor);
    }

    public function updateData(Request $request)
    {
        $vendor = Vendor::find($request->id);
        $vendor->vendor_name = $request->vendor_name;
        $vendor->vendor_contact = $request->vendor_contact;
        $vendor->vendor_address = $request->vendor_address;
        $vendor->save();

        return json_encode([
            'statusCode' => 200
        ]);
    }

    // QUERY INSERT

    public function submit_vendor(Request $request)
    {
        Vendor::create($request->all());

        return json_encode(array(
            "statusCode" => 200
        ));
    }

    public function delete_vendor($id)
    {
        Vendor::find($id)->delete();
        return json_encode(["statusCode" => 200]);
    }
}
