<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class DataBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listBarang = Barang::select('code','name','id','stok')
        //->where('stok','>=',10)->whereBetween('harga',[5000, 15000])
        ->get();

        return response()->json(['message' => 'Data tersedia', 'data' => $listBarang ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'code' => 'required|unique:barang,code',
            'name' => 'required'
        ]);
        #RETURN VALIDATOR
        if($validator->fails())
        {
            $messages = $validator->messages();
            return response()->json(['message' => 'error', 'data' => $messages ], 400);            
        }

        #ELOQUENT
        /* $barang = new Barang();
        $barang->code = $request->input('code');
        $barang->name = $request->input('name');
        $barang->save(); */

        #QUERY BUILDER
        DB::table('barang')->insert(['code'=>$request->input('code'),
        'name'=>$request->input('name')]);

        return response()->json(['message' => 'data berhasil', 'data' => 'berhasil disubmit' ], 201);
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

        return response()->json(['message' => 'Data tersedia', 'data' => $detail ], 200);
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

        return response()->json(['message' => 'Data tersedia', 'data' => $detail ], 200);
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
            return response()->json(['message' => 'error', 'data' => $messages ], 400);            
        }

        #ELOQUENT
        $barang = Barang::find($id);
        $barang->code = $request->input('code');
        $barang->name = $request->input('name');
        $barang->save();

        #QUERY BUILDER
        DB::table('barang')->where('id', $id)->update(['code'=>$request->input('code'),
        'name'=>$request->input('name')]);

        return response()->json(['message' => 'data berhasil', 'data' => 'berhasil diupdate' ], 201);
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
        #DB::table('barang')->where('id',$id)->deleted();

        return response()->json(['message' => 'data berhasil', 'data' => 'berhasil dihapus' ], 201);
    }


    #CUSTOM FUNCTION
    public function updateByCode(Request $request)
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
            return response()->json(['message' => 'error', 'data' => $messages ], 400);            
        }

        #QUERY BUILDER
        DB::table('barang')->where('code', $request->input('code'))->update(['name'=>$request->input('name')]);

        return response()->json(['message' => 'data berhasil', 'data' => 'berhasil diupdate' ], 201);
    }
}
