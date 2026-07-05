<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KomoditasGrading extends Model
{
    use HasFactory;

    protected $table = 'komoditas_grading';

    protected $fillable = [
        'produksi_lahan_id',
        'kelas_ukuran',
        'tingkat_kemanisan',
        'warna',
        'volume_kg',
        'status_validasi',
    ];

    protected function casts(): array
    {
        return [
            'volume_kg' => 'decimal:2',
            'tingkat_kemanisan' => 'integer',
        ];
    }

    public function produksiLahan(): BelongsTo
    {
        return $this->belongsTo(ProduksiLahan::class);
    }

    public function transaksiPasar(): HasMany
    {
        return $this->hasMany(TransaksiPasar::class);
    }
}
