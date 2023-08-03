<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'facility_id', 'department', 'status'
    ];

    public function Facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    public function Position()
    {
        return $this->hasMany(Position::class,'department_id','id');
    }
}
