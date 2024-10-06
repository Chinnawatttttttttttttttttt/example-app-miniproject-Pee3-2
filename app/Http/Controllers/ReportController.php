<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Count;
use App\Models\product;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\PDF;



class ReportController extends Controller
{
    public function ShowReportAndTotal()
    {
        $counts = Count::all()->groupBy('name')->map(function ($group) {
            return $group->sum('quantity');
        });

        $totalSales = Order::all()->sum('total');

        return view('report', compact('counts', 'totalSales'));
    }

    public function ShowReportAndTotale()
    {
        $counts = Count::all()->groupBy('name')->map(function ($group) {
            return $group->sum('quantity');
        });

        $totalSales = Order::all()->sum('total');

        return view('reporte', compact('counts', 'totalSales'));
    }

    public function showReport()
    {
        $data = ['message' => 'This is your report.'];
        return view('pdf.show', compact('data'));
    }

    public function downloadPDF()
    {
        $counts = Count::all()->groupBy('name')->map(function ($group) {
            return $group->sum('quantity');
        });

        $totalSales = Order::all()->sum('total');

        // กำหนดค่าให้กับตัวแปรที่จะส่งไปยัง view
        $data = [
            'counts' => $counts,
            'totalSales' => $totalSales,
            'title' => 'Sales Report', // สมมติว่าคุณต้องการ title นี้
            'date' => date('m/d/Y'), // วันที่ปัจจุบัน
        ];

        $pdf = PDF::loadView('pdf.pdf', $data); // ส่งตัวแปร $data ไปยัง view

        return $pdf->download('report.pdf');
    }

    public function Report_Product()
    {
        $products = product::all();
        return view('pdf.report_product', compact('products'));
    }
}
