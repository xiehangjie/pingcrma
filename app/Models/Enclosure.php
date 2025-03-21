<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enclosure extends Model
{
    use HasFactory;

    protected $fillable = [
        'enclosure_number',
        'capacity'
    ];

    public function crocodiles()
    {
        return $this->hasMany(EnclosureAllocation::class);
    }
}