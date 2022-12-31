<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;
use App\Models\User;

class OtpCode extends Model
{
    use HasFactory, UseUuid;

    protected $fillable = ['otp','user_id','valid_until'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
