<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPemupukan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pemupukan';

    protected $fillable = [
        'user_id',
        'tanggal',
        'jenis_kegiatan',
        'jenis_pupuk_obat',
        'biaya_estimasi',
        'rekomendasi_varietas',
        'sudah_dilaksanakan',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'biaya_estimasi' => 'decimal:2',
            'sudah_dilaksanakan' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
