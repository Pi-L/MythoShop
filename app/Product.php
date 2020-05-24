<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function scopeActive($query) {
        return $query->where('is_active', 1);
    }

    public function orders() {
        return $this->belongsToMany('App\Order')->withPivot('quantity', 'current_price');
    }

    public function categorie() {
        return $this->belongsTo('App\Categorie');
    }
}
