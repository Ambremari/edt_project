<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinksGroups extends Model
{
    use HasFactory;
    use HasCompositePrimaryKey;

    protected $table = 'liensgroupes';
    protected $primaryKey = ['IdDiv', 'IdGrp'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
