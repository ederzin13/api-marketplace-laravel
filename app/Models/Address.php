<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        "userId",
        "street",
        "number",
        "zip",
        "city",
        "state",
        "country"
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function orders() {
        
    }
}
