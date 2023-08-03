<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility', 'address', 'city', 'state', 'zip', 'status'
    ];

    public function Department()
    {
        return $this->hasMany(Department::class,'facility_id','id');
    }
}
