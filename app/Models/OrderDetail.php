<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    

    protected $table = 'order_detail';

    protected $fillable = [
       'order_id','product_id'

    ];
    

   public function order()
   {
       return $this->belongsTo('App\Order', 'order_id');
   }

 
   public function product()
   {
       return $this->belongsTo('App\Product', 'product_id');
   }
}
