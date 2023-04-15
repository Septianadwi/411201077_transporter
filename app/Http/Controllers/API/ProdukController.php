<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;


class ProdukController extends Controller
{
    public function listProduk(Request $request)
    {
        $listProduk = Barang::select('code','name','id','stok')
        ->where('stok','>=',10)->whereBetween('harga',[5000, 15000])->get();

        return response()->json(['message' => 'Data tersedia', 'data' => $listProduk],200);
    }
}
