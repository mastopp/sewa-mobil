<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transactionHeaderModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'description','code','rate_euro','date_paid'
    ]
}
