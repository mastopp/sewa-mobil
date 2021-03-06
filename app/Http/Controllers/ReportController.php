<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\TransactionHeader;
use App\Models\MsCategory;
use App\Models\TransactionDetail;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $kategori = MsCategory::all();

        $keyword = ''; $kat = ''; $start = ''; $end = '';
        if (!empty($request)) {
            $keyword .= $request->keyword;
            $kat .= $request->kategori;
            
        }
        $select = 
            'transaction_header.date_paid as date_paid, ms_category.name as kategori, sum(transaction_detail.value_idr) as value_idr'
        ;
        if (!empty($request->start) && !empty($request->end)) {
            $start .= Carbon::parse($request->start)->toDateString();
            $end .= Carbon::parse($request->end)->toDateString();
            // dd($start.$end);
           $transaction = TransactionHeader::selectRaw($select)
            ->join('transaction_detail', 'transaction_detail.transaction_id', '=', 'transaction_header.id')
            ->join('ms_category', 'ms_category.id', '=', 'transaction_detail.transaction_category_id')
            ->groupBy('transaction_header.date_paid', 'ms_category.id')
            ->where('ms_category.id','like',"%".$kat."%")
            ->where(function($query) use ($request) {
                $query->orWhere('ms_category.name','like',"%".$request->keyword."%");
            })
            ->whereBetween('transaction_header.date_paid', [$start, $end])
            ->orderBy('date_paid', 'ASC')
            ->paginate(10)
            ->appends(request()->query());
        }
        else{            
            $transaction = TransactionHeader::selectRaw($select)
            ->join('transaction_detail', 'transaction_detail.transaction_id', '=', 'transaction_header.id')
            ->join('ms_category', 'ms_category.id', '=', 'transaction_detail.transaction_category_id')
            ->groupBy('transaction_header.date_paid', 'ms_category.id')
            ->where('ms_category.id','like',"%".$kat."%")
            ->where(function($query) use ($request) {
                $query->orWhere('ms_category.name','like',"%".$request->keyword."%");
            })
            ->orderBy('date_paid', 'ASC')
            ->paginate(10)
            ->appends(request()->query());
        }
        
        // dd($transaction);
        return view('admin.report.index', [
            'title' => 'Report Transaction',
            'data' => $transaction,
            'kategori' => $kategori,
        ]);
    }
}
