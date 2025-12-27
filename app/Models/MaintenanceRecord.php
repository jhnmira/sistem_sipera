<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'tanggal_perawatan',
        'deskripsi',
        'teknisi',
        'masalah',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
