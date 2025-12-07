<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charte extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'fichier_path', 'version'];
}