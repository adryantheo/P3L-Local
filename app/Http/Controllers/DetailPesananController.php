<?php

namespace App\Http\Controllers;
use App\Sparepart;
use App\Detail_Pesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class DetailPesananController extends Controller
{
   
    public function index()
    {
        return response()->json(Detail_Pesanan::all(),200);
    }


    public function all()
    {
        return response()->json(Detail_Pesanan::with([
            'pesanan_barangs.sales', 
            'spareparts'
        ])->get(),200);
    }

    public function store(Request $request)
    {

        $status = DB::transaction(function () use ($request){

            //create new detail pengadaaan
            $detail_Pesanan = Detail_Pesanan::create([
                'Nama_Barang' => $request->Nama_Barang,
                'Jumlah_Diterima' => $request->Jumlah_Diterima,
                'Jumlah_Pesan' => $request->Jumlah_Pesan,
                'Harga_Beli' => $request->Harga_Beli,
                'pesanan__barang_id' => $request->pesanan__barang_id,
                'sparepart_id' => $request->sparepart_id,
                'Total_Harga_Beli' => $request->Total_Harga_Beli,
                
            ]);

            //increase stok
            $sparepart = Sparepart::find($detail_Pesanan['sparepart_id']);
            $sparepart->Stok += $detail_Pesanan['Jumlah_Diterima'];
            $sparepart->save();

        },3);
        

        return response()->json([
            'status' => (bool) $status,
            'data'   => $status,
            'message' => $status ? 'Detail_Pesanan Berhasil Ditambahkan!' : 'Error Menambahkan Detail_Pesanan'
        ]);
    }

    public function show(Detail_Pesanan $detail_Pesanan)
    {
        return response()->json($detail_Pesanan::with(['pesanan_barangs', 'spareparts']),200);
    }

    public function update(Request $request, Detail_Pesanan $detail_Pesanan)
    {
        $status = DB::transaction(function () use ($request, &$detail_Pesanan){

         $detail_Pesanan->update(
            $request->only([
                'Nama_Barang',
                'Harga_Beli',
                'Total_Harga_Beli',
                'Jumlah_Diterima',
                'Jumlah_Pesan',
                'pesanan__barang_id',
                'sparepart_id',
        
            ])
        );

         //increase stok
         $sparepart = Sparepart::find($detail_Pesanan['sparepart_id']);
         $sparepart->Stok += $detail_Pesanan['Jumlah_Diterima'];
         $sparepart->save();
    },3);
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Detail_Pesanan Diupdate!' : 'Error Mengupdate Detail_Pesanan'
        ]);
    }

    public function destroy(Detail_Pesanan $detail_Pesanan)
    {
        $status = $detail_Pesanan->delete();

            return response()->json([
                'status' => $status,
                'message' => $status ? 'Detail_Pesanan Berhasil di Hapus!' : 'Error Menghapus Detail_Pesanan'
            ]);
    }
}
