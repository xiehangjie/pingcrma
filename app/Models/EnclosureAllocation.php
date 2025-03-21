<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnclosureAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'crocodile_id',
        'enclosure_id',
    ];

    public function crocodile()
    {
        return $this->belongsTo(Crocodile::class);
    }

    public function enclosure()
    {
        return $this->belongsTo(Enclosure::class);
    }
}
