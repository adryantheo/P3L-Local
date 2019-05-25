<?php

namespace App\Http\Controllers;

use App\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
   
    public function index()
    {
        return response()->json(Transaksi::with(
            'transaksi_service.pegawai',
            'transaksi_service.services',
            'transaksi_service.kendaraans',
            'transaksi_sparepart.spareparts',
            'kustomer',
            'pegawai'
        )->get(),200);
    }

    public function unpaid()
    {
        return response()->json(Transaksi::with(
            'transaksi_service.pegawai',
            'transaksi_service.services',
            'transaksi_service.kendaraans',
            'transaksi_sparepart.spareparts',
            'kustomer',
            'pegawai')
            ->where('is_paid', '<', 1)
            ->get(),200);
    }

    
    public function store(Request $request)
    {
        $transaksi = Transaksi::create([            
            'cabang_id' => $request->cabang_id,
            'Total_Pembelian' => $request->Total_Pembelian,
            'Total_Service' => $request->Total_Service,
            'Total_Seluruh' => $request->Total_Seluruh,
            'Diskon' => $request->Diskon,
            'Status' => $request->Status,           
            'kustomer_id' => $request->kustomer_id,
            'user_id' => $request->user_id, 
            'nama_cs' => $request->nama_cs, 
             
             
        ]);
        
        return response()->json([
            'status' => (bool) $transaksi,
            'data'   => $transaksi,
            'message' => $transaksi ? 'Transaksi Baru Berhasil Ditambahkan!' : 'Error Menambahkan Transaksi Baru'
        ]);
    }

    
    public function show(Transaksi $transaksi)
    {
        //return response()->json($transaksi,200);
        return response()->json(
            Transaksi::with(
            'transaksi_service.pegawai',
            'transaksi_service.services',
            'transaksi_service.kendaraans',
            'transaksi_sparepart.spareparts',
            'kustomer',
            'pegawai'
            )
            ->where('id', '=', $transaksi->id)
            ->first(),200
        );
    }

    public function paid(Transaksi $transaksi)
    {
        $transaksi->is_paid = true;
        $status = $transaksi->save();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Transaksi Paid!' : 'Error Paid Transaksi'
        ]);
    }

    

    
    public function update(Request $request, Transaksi $transaksi)
    {
        $status = $transaksi->update(
            $request->only([
                'Total_Pembelian', 
                'Total_Service',
                'Total_Seluruh',
                'Diskon', 
                'Status', 
                'cabang_id',
                'kustomer_id',
                'user_id',
                'nama_cs'
                
               
        
            ])
        );
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Transaksi Diupdate!' : 'Error Mengupdate Transaksi'
        ]);
    }

    
    public function destroy(Transaksi $transaksi)
    {
        $status = $transaksi->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Transaksi Berhasil di Hapus!' : 'Error Menghapus Transaksi'
        ]);
    }
}
