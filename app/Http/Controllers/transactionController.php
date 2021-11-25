<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class transactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kategori = DB::table('ms_category')->get();

        $keyword = ''; $kat = ''; $start = ''; $end = '';
        if (!empty($request)) {
            $keyword .= $request->keyword;
            $kat .= $request->kategori;
            
        }
        $select = [
            'transaction_header.id as id','transaction_header.description as deskripsi', 'transaction_header.code as code', 'transaction_header.rate_euro as rate_euro', 'transaction_header.date_paid as date_paid', 'ms_category.name as kategori', 'transaction_detail.name as nama_transaksi', 'transaction_detail.value_idr as value_idr'
        ];
        if (!empty($request->start) && !empty($request->end)) {
            $start .= Carbon::parse($request->start)->toDateString();
            $end .= Carbon::parse($request->end)->toDateString();
            // dd($start.$end);
           $transaction = DB::table('transaction_header')
            ->select($select)
            ->join('transaction_detail', 'transaction_detail.transaction_id', '=', 'transaction_header.id')
            ->join('ms_category', 'ms_category.id', '=', 'transaction_detail.transaction_category_id')
            ->where('ms_category.id','like',"%".$kat."%")
            ->where(function($query) use ($request) {
                $query->orWhere('transaction_header.description','like',"%".$request->keyword."%")
                    ->orWhere('transaction_header.code','like',"%".$request->keyword."%")
                    ->orWhere('transaction_detail.name','like',"%".$request->keyword."%")
                    ->orWhere('ms_category.name','like',"%".$request->keyword."%");
            })
            ->whereBetween('transaction_header.date_paid', [$start, $end])
            ->orderBy('date_paid', 'ASC')
            ->paginate(10)
            ->appends(request()->query());
        }
        else{            
            $transaction = DB::table('transaction_header')
            ->select($select)
            ->join('transaction_detail', 'transaction_detail.transaction_id', '=', 'transaction_header.id')
            ->join('ms_category', 'ms_category.id', '=', 'transaction_detail.transaction_category_id')
            ->where('ms_category.id','like',"%".$kat."%")
            ->where(function($query) use ($request) {
                $query->orWhere('transaction_header.description','like',"%".$request->keyword."%")
                    ->orWhere('transaction_header.code','like',"%".$request->keyword."%")
                    ->orWhere('transaction_detail.name','like',"%".$request->keyword."%")
                    ->orWhere('ms_category.name','like',"%".$request->keyword."%");
            })
            ->orderBy('date_paid', 'ASC')
            ->paginate(10)
            ->appends(request()->query());
        }
        
        // dd($transaction);
        return view('admin.transaction.index', [
            'title' => 'Transaction List',
            'data' => $transaction,
            'kategori' => $kategori,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.transaction.create', [
            'title' => 'Insert New Transaction'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return $id;
        return view('admin.transaction.show', [
            'title' => 'Edit Transaction',
            // 'data' => $transaction,
            // 'kategori' => $kategori,
        ]);   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
