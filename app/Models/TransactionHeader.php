<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHeader extends Model
{
    use HasFactory;
    protected $table = 'transaction_header';
    protected $fillable = [
        'description', 'code','rate_euro','date_paid'
    ];
    public $timestamps = false;

    public function transaction_detail()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id','id');
    }
}
