<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KontrakKemitraan extends Model
{
    use HasFactory;

    protected $table = 'kontrak_kemitraan';

    protected $fillable = [
        'petani_id',
        'pedagang_id',
        'kuota_kg',
        'harga_acuan_per_kg',
        'status_kontrak',
        'tanggal_mulai',
        'tanggal_selesai',
        'mekanisme_sengketa',
    ];

    protected function casts(): array
    {
        return [
            'kuota_kg' => 'decimal:2',
            'harga_acuan_per_kg' => 'decimal:2',
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function petani(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petani_id');
    }

    public function pedagang(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pedagang_id');
    }
}
