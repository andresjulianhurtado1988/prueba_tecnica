<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    

    protected $table = 'customers';

    protected $fillable = [
        'customer_id',
        'city_id',
        'customer_id_number',
        'customer_birth_date',
        'customer_address',
        'customer_phone'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at'];
    
   public function city()
   {
    return $this->belongsTo(City::class);
  //  return $this->hasMany('App\City');
   }
/*
  public function order()
   {
    return $this->hasMany('App\Order');
   }
   */
   

}
