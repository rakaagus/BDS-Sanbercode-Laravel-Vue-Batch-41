<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\UseUuid;

class Role extends Model
{
    use HasFactory, UseUuid;

    protected $fillable = ['name'];

    public function users(){
        return $this->hasMany(User::class, "role_id");
    }
}
