<?php

namespace App\Http\Controllers\Report;

use App\Models\itemin;
use App\Models\Itemout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        return view('dashboard.report.index');
    }
    public function detail($category)
    {
        // variable category untuk menentukan data berupa barang masuk atau barang keluar
        $data['title'] = $category;
        $data['tanggal'] = date("d/M/Y");
        $data["dataBarang"] = $category == "MASUK" ? itemin::all() : Itemout::all();
        $data['jumlahQty'] = $category == "MASUK" ? Itemin::select(
            DB::raw('SUM(qty) quantity')
        )->first() : Itemout::select(
            DB::raw('SUM(qty) quantity')
        )->first();

        return view('dashboard.report.detail_report', $data);
    }
    public function to_print($category)
    {
        // variable category untuk menentukan data berupa barang masuk atau barang keluar
        $data['title'] = $category;
        $data['tanggal'] = date("d/M/Y");
        $data["dataBarang"] = $category == "MASUK" ? itemin::all() : Itemout::all();
        $data['jumlahQty'] = $category == "MASUK" ? Itemin::select(
            DB::raw('SUM(qty) quantity')
        )->first() : Itemout::select(
            DB::raw('SUM(qty) quantity')
        )->first();

        return view('dashboard.report.to_print', $data);
    }
}
