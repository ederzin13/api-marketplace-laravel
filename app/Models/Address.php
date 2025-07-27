<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

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
        return $this->belongsTo(User::class, "userId", "id");
    }

    public function orders() {
        
    }
}
