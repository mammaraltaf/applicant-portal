<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $fillable = [
        'department_id', 'position', 'status'
    ];
    public function Department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function Application()
    {
        return $this->hasMany(Application::class,'position_id','id');
    }
}
