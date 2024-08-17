<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Penduduk;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendudukController extends Controller
{
    

    public function getKabupaten(Request $request)
    {
         $data['kabupaten'] = Kabupaten::where("provinsi_id",$request->provinsi_id)
                                ->get(["nama","id"]);
        return response()->json($data);


        dd($data);
    }

    public function index(Request $request)
    {

        $provinsis = Provinsi::latest()->get();

        $kabupatens = Kabupaten::where('provinsi_id', $request->provinsi_id)->get();
    
        $penduduks = Penduduk::latest()
            ->when(request()->q, function($query) {
                $query->where('nama', 'like', '%'. request()->q . '%')
                      ->orWhere('nik', 'like', '%'. request()->q . '%');
            })
            ->when(request()->provinsi_id, function($query) {
                $query->whereHas('provinsi', function($subquery) {
                    $subquery->where('id', request()->provinsi_id);
                });
            })
            ->when(request()->kabupaten_id, function($query) {
                $query->whereHas('kabupaten', function($subquery) {
                    $subquery->where('id', request()->kabupaten_id);
                });
            })
            ->paginate(10);
    
        return view('admin.penduduk.index', compact('penduduks', 'provinsis', 'kabupatens'));
    }
    
 
    public function create()
    {
        $provinsis = Provinsi::latest()->get();
        $kabupatens = Kabupaten::latest()->get();
        return view('admin.penduduk.create', compact('provinsis','kabupatens'));
    }
    

    public function store(Request $request)
    {
       $this->validate($request, [
            'nik'           =>'required',
            'nama'          => 'required|unique:penduduk',
            'jenis_kelamin' =>'required',
            'tanggal_lahir' =>'required',
            'alamat'        =>'required',
            'provinsi_id'   => 'required',
            'kabupaten_id'   => 'required'
       ]); 

       $penduduk = Penduduk::create([
           'nik'            => $request->nik,
           'nama'           => $request->nama,
           'jenis_kelamin'  => $request->jenis_kelamin,
           'tanggal_lahir'  => $request->tanggal_lahir,
           'alamat'         => $request->alamat,
           'provinsi_id'    => $request->provinsi_id,
           'kabupaten_id'   => $request->kabupaten_id
       ]);

       if($penduduk){
            //redirect dengan pesan sukses
            return redirect()->route('admin.penduduk.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.penduduk.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function test(){
        
        try {
            DB::beginTransaction();

            $provinsi = Provinsi::create([
                'nama'   => 'Sumatera Utara',
            ]);
    
            $kabupaten = Kabupaten::create([
                'nama'          => 'Medan',
                'provinsi_id'    =>$provinsi->id,
            ]);
    
            
            $penduduks =Penduduk::create([
                'nik'            => '2103',
                'nama'           => 'abda',
                'jenis_kelamin'  => 'Laki Laki',
                'tanggal_lahir'  => '2003-03-03',
                'alamat'         => 'blok3',
                'provinsi_id'    =>$provinsi->id,
                'kabupaten_id'   =>$kabupaten->id
            ]);
    
            DB::commit();
        } catch (\Throwable $th) {
            $th;
           DB::rollback();
        }
        
       

    }
    
 
    public function edit(Penduduk $penduduk)
    {

        $provinsis = Provinsi::latest()->get();
        $kabupatens = Kabupaten::latest()->get();
        return view('admin.penduduk.edit', compact('penduduk','provinsis','kabupatens'));
    }
    


    public function update(Request $request, Penduduk $penduduk)
    {
        
        $this->validate($request, [
            'nik'           =>'required',
            'nama'          => 'required|unique:penduduk,nama,'.$penduduk->id,
            'jenis_kelamin' =>'required',
            'tanggal_lahir' =>'required',
            'alamat'        =>'required',
            'provinsi_id'   => 'required',
            'kabupaten_id'   => 'required'
       ]); 

            $penduduk = Penduduk::findOrFail($penduduk->id);
            $penduduk->update([
                'nik'            => $request->nik,
                'nama'           => $request->nama,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'alamat'         => $request->alamat,
                'provinsi_id'    => $request->provinsi_id,
                'kabupaten_id'   => $request->kabupaten_id
            ]);

       if($penduduk){
            //redirect dengan pesan sukses
            return redirect()->route('admin.penduduk.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.penduduk.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
 
    public function destroy($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();

        if($penduduk){
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
