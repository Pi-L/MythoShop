<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addresse extends Model
{
    public function users() {
        return $this->belongsToMany('App\User')->withPivot('name');
    }

    public function orderBilling() {
            return $this->hasMany('App\Order', 'billing_addresse_id');
    }

    public function orderShipping() {
            return $this->hasMany('App\Order', 'shipping_addresse_id');
    }
}
