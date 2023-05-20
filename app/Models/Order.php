<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $table = 'orders';

   public function order_detail()
   {
    return $this->hasMany('App\OrderDetail');
   }

   
   public function customer()
   {
    return $this->belongsTo('App\Customer', 'customer_id');
   }


}
