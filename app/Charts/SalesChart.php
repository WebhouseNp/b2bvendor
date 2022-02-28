<?php

declare(strict_types = 1);

namespace App\Charts;

use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class SalesChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $from = $request->from ?? Carbon::now()->subDays(30);
        $to = $request->to ?? Carbon::today();

        $from = ($from instanceof Carbon) ? $from->startOfDay() : Carbon::parse($from)->startOfDay();
		$to   = ($to instanceof Carbon) ? $to->endOfDay() : Carbon::parse($to)->endOfDay();
        
        $reportType = $request->report_type ?? 'date';
        if(auth()->user()->hasRole('vendor')){
            $totalEarnings = \DB::table('orders')->where('vendor_id',auth()->user()->vendor->id)->selectRaw($reportType . '(created_at) as label, sum(total_price)  as total_sales')
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('label')
            ->pluck('total_sales', 'label')
            ->all();
            logger($totalEarnings);
        } else {

            $totalEarnings = \DB::table('orders')->selectRaw($reportType . '(created_at) as label, sum(total_price)  as total_sales')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('label')
                ->pluck('total_sales', 'label')
                ->all();
                logger($totalEarnings);
        }


        $labels = collect(array_keys($totalEarnings))->map(function ($label) use ($reportType) {
            switch ($reportType) {
                case 'year':
                case 'YEAR':
                    return Carbon::createFromFormat('Y', $label)->format('Y');
                case 'month':
                case 'MONTH':
                    return Carbon::createFromFormat('m', $label)->format('M');
                default:
                    return Carbon::createFromFormat('Y-m-d', $label)->format('M d');
            }
        })->toArray();

        return Chartisan::build()
            ->labels($labels)
            ->dataset('Sales', array_values($totalEarnings));
    }
}