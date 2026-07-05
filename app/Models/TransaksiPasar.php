<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiPasar extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pasar';

    protected $fillable = [
        'petani_id',
        'pedagang_id',
        'komoditas_grading_id',
        'volume_kg',
        'harga_per_kg',
        'harga_konsumen_per_kg',
        'total_bayar',
        'status_logistik',
        'tingkat_kerusakan_persen',
        'status_transaksi',
        'tanggal_transaksi',
    ];

    protected function casts(): array
    {
        return [
            'volume_kg' => 'decimal:2',
            'harga_per_kg' => 'decimal:2',
            'harga_konsumen_per_kg' => 'decimal:2',
            'total_bayar' => 'decimal:2',
            'tingkat_kerusakan_persen' => 'decimal:2',
            'tanggal_transaksi' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (TransaksiPasar $transaksi): void {
            $volume = (float) ($transaksi->volume_kg ?? 0);
            $harga = (float) ($transaksi->harga_per_kg ?? 0);
            $transaksi->total_bayar = round($volume * $harga, 2);
        });
    }


    public function getMarginPersenAttribute(): float
    {
        $hargaKonsumen = (float) ($this->harga_konsumen_per_kg ?? 0);
        $hargaPetani = (float) ($this->harga_per_kg ?? 0);

        if ($hargaKonsumen <= 0) {
            return 0.0;
        }

        return round((($hargaKonsumen - $hargaPetani) / $hargaKonsumen) * 100, 2);
    }

    public function petani(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petani_id');
    }

    public function pedagang(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pedagang_id');
    }

    public function komoditasGrading(): BelongsTo
    {
        return $this->belongsTo(KomoditasGrading::class, 'komoditas_grading_id');
    }
}
