<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_id', 'firstname', 'lastname', 'phone', 'email', 'address', 'resume', 'experience`',
        'messageupdate', 'status'
    ];

    public function Position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

}
