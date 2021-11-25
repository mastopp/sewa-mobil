<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsCategory extends Model
{
    use HasFactory;
    protected $table = 'ms_category';
    protected $fillable = ['name'];
    public $timestamps = false;
    public function transaction_detail()
    {
        return $this->hasMany(transaction_detail::class);
    }
}
