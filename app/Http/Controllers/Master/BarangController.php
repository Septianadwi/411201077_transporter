<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


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
        #setting
        $input = $request->all();
        $validator = Validator::make($input, [
            'code' => 'required|unique:code',
            'name' => 'required'
        ]);
        #RETURN VALIDATOR
        if($validator->fails())
        {
            $messages = $validator->messages();
            return Redirect::back()->withErrors($messages)->withInput($request->all());
        }

        #ELOQUENT
        $barang = new Barang();
        $barang->code = $request->input('code');
        $barang->name = $request->input('name');
        $barang->save();

        #QUERY BUILDER
        DB::table('barang')->insert(['code'=>$request->input('code'),
        'name'=>$request->input('name')]);

        return redirect('barang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = Barang::find($id); //DB::table('barang')->where('id', $id)->first();

        return view('master.viewbarang', compact('detail'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detail = Barang::find($id); //DB::table('barang')->where('id', $id)->first();

        return view('master.editbarang', compact('detail'));
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
        #setting
        $input = $request->all();
        $validator = Validator::make($input, [
            'kode_barang' => 'required',
            'nama_barang' => 'required'
        ]);
        #RETURN VALIDATOR
        if($validator->fails())
        {
            $messages = $validator->messages();
            return Redirect::back()->withErrors($messages)->withInput($request->all());
        }

        #ELOQUENT
        $barang = Barang::find($id);
        $barang->code = $request->input('code');
        $barang->name = $request->input('name');
        $barang->save();

        #QUERY BUILDER
        DB::table('barang')->where('id', $id)->update(['code'=>$request->input('code'),
        'name'=>$request->input('name')]);

        return redirect('listbarang');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        #SOFT DELETE
        DB::table('barang')->where('id',$id)
        ->update(['deleted_at'=> date('Y-m-d')]);

        #HARD DELETE
        DB::table('barang')->where('id',$id)->deleted();


        return redirect('master/barang');
    }
}
