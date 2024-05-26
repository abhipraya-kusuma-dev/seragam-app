<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\StringHelper;
use App\Models\Order;
use Exception;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function lihatOrderan(Request $request){
        $orders = DB::table('seragams')
        ->join('statuses', 'seragams.id','=','statuses.seragam_id')
        ->select('seragams.nama_barang','seragams.ukuran',DB::raw('SUM(statuses.kuantitas) as QTY'),'seragams.jenjang','seragams.id','seragams.harga')
        ->groupBy('seragams.id', 'seragams.nama_barang', 'seragams.ukuran', 'seragams.jenjang', 'seragams.harga')
        ->get();

        foreach($orders as $d){
            $status = DB::table('statuses')
            ->select('seragam_id','kuantitas')
            ->get();
            foreach($status as $e){
            if($d->id == $e->seragam_id){
                $d->total_penjualan = $d->total_penjualan ?? 0;
                $d->total_penjualan = $d->total_penjualan + ($d->harga * $e->kuantitas);
            }
        }
        
    }
        dd($orders->unique('nama_barang'));
    }
    
}
