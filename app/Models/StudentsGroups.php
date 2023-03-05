<?php

namespace App\Models;

use App\Events\CompoGroupesCreatingEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Notifications\Notifiable;

class StudentsGroups extends Model
{
    use HasFactory;
    use Notifiable;
    use HasCompositePrimaryKey;

    protected $table = 'compogroupes';
    protected $primaryKey = ['IdEleve', 'IdGrp'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected $dispatchesEvents = [
        'creating' => CompoGroupesCreatingEvent::class,
    ];
}
