<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $jenjang;
    protected $tanggal;
    protected $endRow;
    protected $endColumn;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($jenjang, $tanggal)
    {
        $this->jenjang=$jenjang;
        $this->tanggal=$tanggal;
        
    }
    public function collection(){
        

        $orders = DB::table('seragams')
        ->join('statuses', 'seragams.id','=','statuses.seragam_id')
        ->join('orders', 'orders.id', '=', 'statuses.order_id')
        ->when($this->tanggal, function(Builder $builder) {
            return $builder->whereDate('orders.created_at','=',Carbon::parse($this->tanggal));
        })
        ->when($this->jenjang, function(Builder $builder) {
            return $builder->where('seragams.jenjang','LIKE', "%$this->jenjang%");
        })
        ->select('seragams.nama_barang','seragams.ukuran',DB::raw('SUM(statuses.kuantitas) as QTY'),'seragams.jenjang','seragams.id','seragams.harga', 'orders.created_at')
        ->groupBy('seragams.id', 'seragams.nama_barang', 'seragams.ukuran', 'seragams.jenjang', 'seragams.harga','orders.created_at')
        ->get();



        foreach($orders as $order){
            $status = DB::table('statuses')
            ->select('seragam_id','kuantitas')
            ->get();
            foreach($status as $e){
            if($order->id == $e->seragam_id){
                $order->total_penjualan = $order->total_penjualan ?? 0;
                $order->total_penjualan = $order->total_penjualan + ($order->harga * $e->kuantitas);
            }
        }
        
    }
      
       $orders=$orders->unique('nama_barang');
       $data=collect([]);
       foreach($orders as $order){
        $data->push([
            'nama_barang'=>$order->nama_barang,
            'ukuran'=>$order->ukuran,
            'QTY'=>$order->QTY,
            'jenjang'=>$order->jenjang,
            'harga'=>$order->harga,
            'created_at'=>Carbon::parse($order->created_at, 'Asia/Jakarta')->format('d-m-Y h:m'),
            'total_penjualan'=>$order->total_penjualan
        ]);
       }

       $this->endRow=$orders->count() + 3;
       $this->endColumn='G';
       return $data;
    }
    public function headings(): array{

        return [
            ['Laporan Order stok seragam'],
            [$this->tanggal=Carbon::parse('Asia/Jakarta')->format('d-m-Y')],
            ['nama_barang','ukuran','QTY','jenjang','harga','created_at','total_penjualan']];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2:G2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $formatCode = '_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)';
        $sheet->getStyle("F4:F"."$this->endRow")->getNumberFormat()->setFormatCode($formatCode);
        $sheet->getStyle("G4:G"."$this->endRow")->getNumberFormat()->setFormatCode($formatCode);

        $sheet->getStyle("A3:$this->endColumn"."$this->endRow")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        
        return [
            // Style the first row as bold and set the background color
            3 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFFD222'],
                ],
               
            ],
            1 => [
                'font' => ['bold' => true, 'size' => 24],
                
            ]
        ];
    }
    // public function columnFormats(): array{
    //     return [
    //         'F' => NumberFormat::FORMAT_CURRENCY_IDR,
    //         'H' => NumberFormat::FORMAT_CURRENCY_USD_INTEGER
    //     ];
    // }
}
