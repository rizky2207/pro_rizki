<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class KabupatenController extends Controller
{
    public function index()
    {
        $kabupatens = Kabupaten::latest()->when(request()->q, function($kabupatens) {
            $kabupatens = $kabupatens->where('nama', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.kabupaten.index', compact('kabupatens'));
    }
    
 
    public function create()
    {
        $provinsis = Provinsi::latest()->get();
        return view('admin.kabupaten.create', compact('provinsis'));
    }
    

    public function store(Request $request)
    {
       $this->validate($request, [
           'nama'          => 'required|unique:kabupaten',
           'provinsi_id'    => 'required',
       ]); 

       $kabupaten = Kabupaten::create([
           'nama'          => $request->nama,
           'provinsi_id'    => $request->provinsi_id,
       ]);

       if($kabupaten){
            //redirect dengan pesan sukses
            return redirect()->route('admin.kabupaten.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.kabupaten.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    
 
    public function edit(Kabupaten $kabupaten)
    {
        $provinsis = Provinsi::latest()->get();
        return view('admin.kabupaten.edit', compact('kabupaten', 'provinsis'));
    }
    


    public function update(Request $request, Kabupaten $kabupaten)
    {
       $this->validate($request, [
           'nama'          => 'required|unique:kabupaten,nama,'.$kabupaten->id,
           'provinsi_id'    => 'required',
       ]); 

            $kabupaten = Kabupaten::findOrFail($kabupaten->id);
            $kabupaten->update([
                'nama'          => $request->nama,
                'provinsi_id'    => $request->provinsi_id,
            ]);

       if($kabupaten){
            //redirect dengan pesan sukses
            return redirect()->route('admin.kabupaten.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.kabupaten.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
 
    public function destroy($id)
    {
        $kabupaten = Kabupaten::findOrFail($id);
        $kabupaten->delete();

        if($kabupaten){
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
