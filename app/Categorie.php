<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    public function scopeActive($query) {
        return $query->where('is_active', 1);
    }

    public function products() {
        return $this->hasMany('App\Product');
    }
}
