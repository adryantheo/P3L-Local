<?php

namespace App\Http\Controllers;

use App\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
   
    public function index()
    {
        return response()->json(Sparepart::all(),200);
    }

    public function all()
    {
        return response()->json(Sparepart::whereRaw('Stok < Stok_Min')->get(),200);
    }

   
    public function store(Request $request)
    {
        

        $sparepart = Sparepart::create([
            'Kode_Sparepart' => $request->Kode_Sparepart,
            'Nama' => $request->Nama,
            'Tipe' => $request->Tipe,
            'Merk' => $request->Merk,
            'Gambar' => $this->uploadGambar($request),
            'Jenis_Motor' => $request->Jenis_Motor,
            
            'Harga_Jual' => $request->Harga_Jual,
            'Letak' => $request->Letak,
            'Stok' => $request->Stok,
            'Stok_Min' => $request->Stok_Min,      
           
           
        ]);

        return response()->json([
            'status' => (bool) $sparepart,
            'data'   => $sparepart,
            'message' => $sparepart ? 'Sparepart Berhasil Ditambahkan!' : 'Error Menambahkan Sparepart'
        ]);
    }

    public function uploadGambar(Request $request, $name = null )
    {
        if($request->hasFile('Gambar')){
            $image = $request->file('Gambar');

            if (is_null($name)) {
                $name = time() . "_" . rand(1000, 1000000) . "." . $image->getClientOriginalExtension();
            }

            $image->move(public_path('images'), $name);

            return '/8786/public/images/'.$name;
        }

        return '';
    }

    
    public function show(Sparepart $sparepart)
    {
        return response()->json($sparepart,200);
    }

    
    public function update(Request $request, $sparepart)
    {
        
        $status = Sparepart::find($sparepart);
        $status->Kode_Sparepart= $request['Kode_Sparepart'];
        $status->Nama= $request['Nama'];
        $status->Tipe= $request['Tipe'];
        $status->Merk= $request['Merk'];
        $status->Jenis_Motor= $request['Jenis_Motor'];
        $status->Harga_Jual= $request['Harga_Jual'];
        $status->Letak= $request['Letak'];
        $status->Stok= $request['Stok'];
        $status->Stok_Min= $request['Stok_Min'];
        if($request->hasFile('Gambar')){
            $status->Gambar= $this->uploadGambar($request);
        }
        
        $status->update();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Sparepart Diupdate!' : 'Error Mengupdate Sparepart'
        ]);
    }

    
    public function destroy(Sparepart $sparepart)
    {
        $status = $sparepart->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Pegawai Berhasil di Hapus!' : 'Error Menghapus Pegawai'
        ]);
    }
}


