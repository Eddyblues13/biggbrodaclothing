<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_number', 'total', 'status', 'order_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
