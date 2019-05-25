<?php

namespace App\Http\Controllers;

use App\Kustomer;
use Illuminate\Http\Request;

class KustomerController extends Controller
{
    
    public function index()
    {
        return response()->json(Kustomer::all(),200);
    }

    public function all()
    {
        return response()->json(Kustomer::with('kendaraans')->get(),200);      
    }

    public function listNamaKustomer()
    {
        return Kustomer::select('id', 'Nama_Kustomer')->get();
    }

    public function findKustomer(Request $request, $notelp)
    {
        //$request->Telepon_Kustomer;
        $data = Kustomer::where('Telepon_Kustomer', "LIKE", $notelp)->with('kendaraans')->first();

        return response()->json($data, 200);
    }

    
   
    public function store(Request $request)
    {
        $kustomer = Kustomer::create([
            'Nama_Kustomer' => $request->Nama_Kustomer,
            'Alamat_Kustomer' => $request->Alamat_Kustomer,
            'Telepon_Kustomer' => $request->Telepon_Kustomer,
          
        ]);

        return response()->json([
            'status' => (bool) $kustomer,
            'data'   => $kustomer,
            'message' => $kustomer ? 'Kustomer Berhasil Ditambahkan!' : 'Error Menambahkan Kustomer'
        ]);
    }

    
    public function show(Request $request)
    {
        return response()->json($kustomer,200);
    }

   
  
    public function update(Request $request, Kustomer $kustomer)
    {
        $status = $kustomer->update(
            $request->only([
                'Nama_Kustomer', 
                'Alamat_Kustomer', 
                'Telepon_Kustomer'                
        
            ])
        );
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Kustomer Diupdate!' : 'Error Mengupdate Kustomer'
        ]);
    }

    
    public function destroy(Kustomer $kustomer)
    {
        $status = $kustomer->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Kustomer Berhasil di Hapus!' : 'Error Menghapus Kustomer'
        ]);
    }
}
