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
    public function ShowSales_Summary()
    {
        $counts = Count::all()->groupBy('name')->map(function ($group) {
            return $group->sum('quantity');
        });

        $totalSales = Order::all()->sum('total');

        return view('sales_summary', compact('counts', 'totalSales'));
    }

    public function ShowReportAndTotale()
    {
        $counts = Count::all()->groupBy('name')->map(function ($group) {
            return $group->sum('quantity');
        });

        $totalSales = Order::all()->sum('total');

        return view('reporte', compact('counts', 'totalSales'));
    }

    public function Report_Product()
    {
        $products = product::all();
        return view('pdf.report_product', compact('products'));
    }

    public function report_sales()
{
    $date = date('d-m-Y');
    $orders = Order::all();
    $totalSales = $orders->sum('total');
    $counts = Count::select('name', DB::raw('SUM(quantity) as total_quantity'))
                   ->groupBy('name')
                   ->get();

    return view('pdf.report_sales', compact('orders', 'counts', 'totalSales', 'date'));
}

}
