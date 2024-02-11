<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class apiHitDetails extends Model
{
    use HasFactory;

    public function drivers()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trips (){
        return $this->belongsTo(Trip::class, 'trip_id');
    }


    protected  $table = 'apihit_details';

    protected  $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'trip_id',
        'details',
    ];

    public $timestamps = true;

}
