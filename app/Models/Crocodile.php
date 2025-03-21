<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crocodile extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'rfid_tag',
        'species_type',
        'name',
        'age',
        'weight',
        'pool_id',
        'gender',
        'birth_date',
        'genetic_lineage',
        'health_status',
    ];

    public function pool(): BelongsTo
    {
        return $this->belongsTo(Pool::class);
    }
}
