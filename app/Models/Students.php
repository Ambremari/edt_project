<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $table = 'eleves';
    protected $primaryKey = ['IdEleve'];
    public $incrementing = false;
    protected $keyType = 'string';
}
