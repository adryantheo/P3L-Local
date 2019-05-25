<?php

namespace App\Http\Controllers;

use App\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
   
    public function index()
    {
        return response()->json(Cabang::all(),200);
    }

    
    public function store(Request $request)
    {
        $cabang = Cabang::create([
            'Nama_Cabang' => $request->Nama_Cabang,
            'Alamat_Cabang' => $request->Alamat_Cabang,
          
            
            
        ]);

        return response()->json([
            'status' => (bool) $cabang,
            'data'   => $cabang,
            'message' => $cabang ? 'Cabang Baru Berhasil Ditambahkan!' : 'Error Menambahkan Cabang Baru'
        ]);
    }

    
    public function show(Cabang $cabang)
    {
        return response()->json($cabang,200);
    }

    public function update(Request $request, Cabang $cabang)
    {
        $status = $cabang->update(
            $request->only([
                'Nama_Cabang', 
                'Alamat_Cabang', 
               
        
            ])
        );
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Cabang Diupdate!' : 'Error Mengupdate Cabang'
        ]);
    }

  
    public function destroy(Cabang $cabang)
    {
        $status = $cabang->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Cabang Berhasil di Hapus!' : 'Error Menghapus Cabang'
        ]);
    }
}
