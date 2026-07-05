<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $nama
 * @property string $email
 * @property string $password
 * @property int|null $umur
 * @property string|null $tingkat_pendidikan
 * @property string $role
 * @property string|null $id_kelompok_tani
 * @property string|null $no_hp
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'umur',
        'tingkat_pendidikan',
        'role',
        'id_kelompok_tani',
        'no_hp',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'umur' => 'integer',
        ];
    }

    public function scopePetani(Builder $query): Builder
    {
        return $query->where('role', 'petani');
    }

    public function scopePedagang(Builder $query): Builder
    {
        return $query->where('role', 'pedagang');
    }

    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('role', 'admin');
    }

    public function produksiLahan(): HasMany
    {
        return $this->hasMany(ProduksiLahan::class);
    }

    public function transaksiSebagaiPetani(): HasMany
    {
        return $this->hasMany(TransaksiPasar::class, 'petani_id');
    }

    public function transaksiSebagaiPedagang(): HasMany
    {
        return $this->hasMany(TransaksiPasar::class, 'pedagang_id');
    }

    public function kontrakSebagaiPetani(): HasMany
    {
        return $this->hasMany(KontrakKemitraan::class, 'petani_id');
    }

    public function kontrakSebagaiPedagang(): HasMany
    {
        return $this->hasMany(KontrakKemitraan::class, 'pedagang_id');
    }

    public function preferensiKonsumenDibuat(): HasMany
    {
        return $this->hasMany(PreferensiKonsumen::class, 'dibuat_oleh');
    }

    public function jadwalPemupukan(): HasMany
    {
        return $this->hasMany(JadwalPemupukan::class);
    }

    public function pengumumanDibuat(): HasMany
    {
        return $this->hasMany(Pengumuman::class, 'dibuat_oleh');
    }
}
