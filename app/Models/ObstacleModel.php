<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObstacleModel extends Model
{
    use HasFactory;

    protected $table = 'obstacles';
    public $timestamps = false;

    protected $fillable = [
        'x',
        'y',
    ];
}
