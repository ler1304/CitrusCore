<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProduksiLahan extends Model
{
    use HasFactory;

    protected $table = 'produksi_lahan';

    protected $fillable = [
        'user_id',
        'luas_lahan',
        'jumlah_pohon',
        'estimasi_panen',
        'realisasi_panen',
        'tanggal_estimasi_panen',
    ];

    protected function casts(): array
    {
        return [
            'luas_lahan' => 'decimal:2',
            'estimasi_panen' => 'decimal:2',
            'realisasi_panen' => 'decimal:2',
            'tanggal_estimasi_panen' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function komoditasGrading(): HasMany
    {
        return $this->hasMany(KomoditasGrading::class);
    }
}
