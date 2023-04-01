<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #ELOQUENT
        $totalBarang = Barang::select('id')
            ->where('stok','>=',10)->whereBetween('harga',[5000, 15000])
            ->sum('stok');

        #ELOQUENT KOMBINASI RAW
        $totalHarga = Barang::select(DB::Raw('sum(harga) as totalHarga'))
            ->where('stok','>=',10)->whereBetween('harga',[5000, 15000])
            ->first();


        $listBarang = Barang::select('code','name','id','stok')
        ->where(function($q){
            $q->where('code','like','%kode%')->orWhere('name','like','%kode%');
        })
        ->where('stok','>=',10)->whereBetween('harga',[5000, 15000])->get();

        return view('master.listbarang', compact('listBarang', 'totalBarang','totalHarga'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.formbarang');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
