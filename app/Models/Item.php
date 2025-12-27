<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'id',
        'kode_barang',
        'nup',
        'nama',
        'merek',
        'nomor_seri',
        'lokasi',
        'kondisi',
        'tanggal_servis_terakhir',
        'interval_servis',
        'tanggal_servis_selanjutnya',
    ];

    protected $casts = [
        'tanggal_servis_terakhir' => 'date',
        'tanggal_servis_selanjutnya' => 'date',
    ];

    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecord::class)->orderBy('tanggal_perawatan', 'desc');
    }

    public function scopeFilter($query, $filters){
        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nup', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('kondisi', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['kondisi'])) {
            $query->where('kondisi', $filters['kondisi']);
        }

        if (!empty($filters['lokasi'])) {
            $query->where('lokasi', $filters['lokasi']);
        }

        return $query;
    }
}
