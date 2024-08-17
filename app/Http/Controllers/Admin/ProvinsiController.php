<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class ProvinsiController extends Controller
{
    public function index()
    {
        $provinsis = Provinsi::latest()->when(request()->q, function($provinsis) {
            $provinsis = $provinsis->where('nama', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.provinsi.index', compact('provinsis'));
    }

    public function create()
    {
        return view('admin.provinsi.create');
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
       $this->validate($request, [
           'nama'  => 'required|unique:provinsi' 
       ]); 

       $provinsi = Provinsi::create([
           'nama'   => $request->nama,
       ]);

       if($provinsi){
            //redirect dengan pesan sukses
            return redirect()->route('admin.provinsi.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.provinsi.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    
    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $category
     * @return void
     */
    public function edit(Provinsi $provinsi)
    {
        return view('admin.provinsi.edit', compact('provinsi'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $category
     * @return void
     */
    public function update(Request $request, Provinsi $provinsi)
    {
        $this->validate($request, [
            'nama'  => 'required|unique:provinsi,nama,'.$provinsi->id 
        ]); 
        
            $provinsi = Provinsi::findOrFail($provinsi->id);
            $provinsi->update([
                'nama'   => $request->nama,
            ]);


        if($provinsi){
            //redirect dengan pesan sukses
            return redirect()->route('admin.provinsi.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.provinsi.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $provinsi = Provinsi::findOrFail($id);
        $provinsi->delete();

        if($provinsi){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
