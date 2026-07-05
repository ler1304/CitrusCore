<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreferensiKonsumen extends Model
{
    use HasFactory;

    protected $table = 'preferensi_konsumen';

    protected $fillable = [
        'dibuat_oleh',
        'judul_survei',
        'warna_favorit',
        'ukuran_favorit',
        'estimasi_permintaan_kg',
        'periode',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'estimasi_permintaan_kg' => 'decimal:2',
            'periode' => 'date',
        ];
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
