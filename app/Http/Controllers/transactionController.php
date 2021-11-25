<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\TransactionHeader;
use App\Models\MsCategory;
use App\Models\TransactionDetail;

class TransactionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kategori = MsCategory::all();

        $keyword = ''; $kat = ''; $start = ''; $end = '';
        if (!empty($request)) {
            $keyword .= $request->keyword;
            $kat .= $request->kategori;
            
        }
        $select = [
            'transaction_header.id as id_transaction','transaction_detail.id as id','transaction_header.description as deskripsi', 'transaction_header.code as code', 'transaction_header.rate_euro as rate_euro', 'transaction_header.date_paid as date_paid', 'ms_category.name as kategori', 'transaction_detail.name as nama_transaksi', 'transaction_detail.value_idr as value_idr'
        ];
        if (!empty($request->start) && !empty($request->end)) {
            $start .= Carbon::parse($request->start)->toDateString();
            $end .= Carbon::parse($request->end)->toDateString();
            // dd($start.$end);
           $transaction = TransactionHeader::select($select)
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
            $transaction = TransactionHeader::select($select)
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
        $kategori = MsCategory::all();

        return view('admin.transaction.create', [
            'title' => 'Insert New Transaction',
            'kategori' => $kategori
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
        // dd($request);
            $this->validate($request, [
               'description' => 'required',
               'code' => 'required',
               'rate_euro' => 'required|numeric|max:100000',
               'date_paid' => 'required',
               'name.*.*'  => 'required|string|distinct|min:3',
               'value_idr.*.*'  => 'required|numeric|',
            ]);
        
        try {
            $store = TransactionHeader::create([
               'description' => $request->description,
               'code' => $request->code,
               'rate_euro' => $request->rate_euro,
               'date_paid' => Carbon::parse($request->date_paid)->toDateString(),
            ]);
            $detail = [];
            foreach($request->kategori as $k => $kategori) {
                foreach ($request->name[$k] as $key => $name) {
                    $detail[] = [
                        'transaction_id' => $store->id,
                        'transaction_category_id'   => $kategori,
                        'name' => $name,
                        'value_idr' => $request->value_idr[$k][$key],
                    ];
                    
                }
            }

            // dd($detail);
                
            TransactionDetail::insert($detail);
            
            return redirect('admin/transaction')->with('success', 'Saved Successfully!');
        } catch (Exception $e) {
            return back()->with('error','Oh snap! Please check your input. '.$e->getMessage());
            
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kategori = MsCategory::all();
        $transaction_header = TransactionHeader::findOrFail($id);
        $transaction_detail = TransactionDetail::where('transaction_id', $id)->get();

        return view('admin.transaction.show', [
            'title' => 'Edit Transaction',
            'data_header' => $transaction_header,
            'data_detail' => $transaction_detail,
            'kategori' => $kategori,
        ]);   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $this->validate($request, [
           'description' => 'required',
           'code' => 'required',
           'rate_euro' => 'required|numeric|max:100000',
           'date_paid' => 'required',
           'name.*'  => 'required|string|distinct|min:3',
           'value_idr.*'  => 'required|numeric|',
        ]);
        try {
            $up = TransactionHeader::where('id',$request->id)
            ->update([
               'description' => $request->description,
               'code' => $request->code,
               'rate_euro' => $request->rate_euro,
               'date_paid' => Carbon::parse($request->date_paid)->toDateString(),
            ]);
            foreach ($request->name as $key => $name) {
                $up_detail = TransactionDetail::where('id', $request->id_detail[$key])
                ->update([
                    'transaction_category_id' => $request->kategori[$key],
                    'name' => $name,
                    'value_idr' => $request->value_idr[$key],
                ]);
                
            }

            // dd($detail);
            
            return redirect('admin/transaction')->with('success', 'Update Successfully!');
        } catch (Exception $e) {
            return back()->with('error','Oh snap! Please check your input. '.$e->getMessage());
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction_detail = TransactionDetail::findOrFail($id);
        $transaction_detail->delete();

        if ($transaction_detail) {
            return redirect('admin/transaction')->with('success', 'Deleted Successfully!');
        }
        else{
            return redirect('admin/transaction')->with('error', 'Oh snap. Data cannot deleted!');
        }
    }
}
