<?php

namespace App\Http\Controllers;

use App\Transaksi_Sparepart;
use App\Sparepart;
use App\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransaksiSparepartController extends Controller
{
    
    public function index()
    {
        return response()->json(Transaksi_Sparepart::all(),200);
    }

    
    public function store(Request $request)
    {
        $status = DB::transaction(function () use ($request, &$transaksi_Sparepart)
        {
            //create a new transaction
            $transaksi_Sparepart = Transaksi_Sparepart::create([
                'Jumlah_Dibeli' => $request->Jumlah_Dibeli,
                'Subtotal' => $request->Subtotal,
                'Sisa_Stok' => $request->Sisa_Stok,
                'transaksi_id' => $request->transaksi_id,
                'sparepart_id' => $request->sparepart_id,
                'user_id' => $request->user_id,
            ]);
            //Stock & Subtotal Function
            $sparepart = Sparepart::find($transaksi_Sparepart['sparepart_id']);
            $sparepart->Stok -= $transaksi_Sparepart['Jumlah_Dibeli'];
            $transaksi_Sparepart->Subtotal *= $sparepart['Harga_Jual'];
            $sparepart->save();
            $transaksi_Sparepart->save();

            //create total harga nota
            $transaksi = Transaksi::find($transaksi_Sparepart['transaksi_id']);
            $transaksi->Total_Pembelian += $transaksi_Sparepart['Subtotal'];
            $transaksi->Total_Seluruh += $transaksi_Sparepart['Subtotal'];
            $transaksi->save();

        },3);

       

        return response()->json([
            'status' => (bool) $status,
            'data'   => $transaksi_Sparepart,
            'message' => $transaksi_Sparepart ? 'Transaksi Baru Berhasil Ditambahkan!' : 'Error Menambahkan Transaksi Baru'
        ]);
    }

    
    public function show(Transaksi_Sparepart $transaksi_Sparepart)
    {
        return response()->json($transaksi_Sparepart,200);
    }

    
    public function update(Request $request, Transaksi_Sparepart $transaksi_Sparepart)
    {
        
            //Update
           $status= $transaksi_Sparepart->update(
                $request->only([
                    'Jumlah_Dibeli',
                    'Subtotal',
                    'Sisa_Stok',
                    'transaksi_id',
                    'sparepart_id', 
                ])
                );
               
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Transaksi Diupdate!' : 'Error Mengupdate Transaksi'
        ]);
    }

    
    public function destroy(Transaksi_Sparepart $transaksi_Sparepart)
    {

        

        $status = $transaksi_Sparepart->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Transaksi Berhasil di Hapus!' : 'Error Menghapus Transaksi'
        ]);
    }
}
