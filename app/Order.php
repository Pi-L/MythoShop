<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function addresseBilling() {
            return $this->belongsTo('App\Addresse','billing_addresse_id', 'id');
    }

    public function addresseShipping() {
            return $this->belongsTo('App\Addresse','shipping_addresse_id', 'id');
    }

    public function products() {
            return $this->belongsToMany('App\Product')->withPivot('quantity', 'current_price');
    }

}
