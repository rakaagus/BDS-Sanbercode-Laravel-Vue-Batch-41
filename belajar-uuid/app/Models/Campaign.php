<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UseUuid;

class Campaign extends Model
{
    use HasFactory, UseUuid;

    protected $fillable = [
        'title',
        'description',
        'address',
        'image',
        'required',
        'collected',
    ];
}
