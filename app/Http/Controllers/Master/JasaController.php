<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class JasaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #ELOQUENT
        $totalBarang = Jasa::select('id')
            ->where('stok','>=',10)->whereBetween('harga',[5000, 15000])
            ->sum('stok');

        #ELOQUENT KOMBINASI RAW
        $totalHarga = Jasa::select(DB::Raw('sum(harga) as totalHarga'))
            ->where('stok','>=',10)->whereBetween('harga',[5000, 15000])
            ->first();


        $listBarang = Jasa::select('code','name','id')->get();

        return view('master.listjasa', compact('listBarang', 'totalBarang','totalHarga'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.formjasa');
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
         $barang = new Jasa();
         $barang->code = $request->input('code');
         $barang->name = $request->input('name');
         $barang->save();
 
         #QUERY BUILDER
         DB::table('jasa')->insert(['code'=>$request->input('code'),
         'name'=>$request->input('name')]);
 
         return redirect('jasa');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = Jasa::find($id); //DB::table('barang')->where('id', $id)->first();

        return view('master.viewjasa', compact('detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detail = Jasa::find($id); //DB::table('barang')->where('id', $id)->first();

        return view('master.editjasa', compact('detail'));
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
            'code' => 'required',
            'name' => 'required'
        ]);
        #RETURN VALIDATOR
        if($validator->fails())
        {
            $messages = $validator->messages();
            return Redirect::back()->withErrors($messages)->withInput($request->all());
        }

        #ELOQUENT
        $barang = Jasa::find($id);
        $barang->code = $request->input('code');
        $barang->name = $request->input('name');
        $barang->save();

        #QUERY BUILDER
        DB::table('jasa')->where('id', $id)->update(['code'=>$request->input('code'),
        'name'=>$request->input('name')]);

        return redirect('barang');
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
        DB::table('jasa')->where('id',$id)
        ->update(['deleted_at'=> date('Y-m-d')]);

        #HARD DELETE
        DB::table('jasa')->where('id',$id)->deleted();


        return redirect('master/jasa');
    }
}
