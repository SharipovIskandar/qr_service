<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'text', 'qr_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

