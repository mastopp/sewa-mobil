<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $table = 'transaction_detail';
    protected $fillable = [
        'transaction_id', 'transaction_category_id', 'name', 'value_idr'
    ];
    public $timestamps = false;
    public function transaction_header()
    {
        return $this->hasOne(transaction_header::class);
    }
    public function ms_category()
    {
        return $this->hasOne(ms_category::class);
    }
}
