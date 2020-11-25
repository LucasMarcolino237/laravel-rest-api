<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogs extends Model
{
    use HasFactory;

    $fillable = [
        'user_id',
        'data_old',
        'data_new'
    ];

    public function logs()
    {
        return $this->belongsTo(User::class);
    }
}
