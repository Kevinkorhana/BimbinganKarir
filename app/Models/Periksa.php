<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periksa extends Model
{
    use HasFactory;

    protected $table = 'periksas';
    protected $fillable = [
        'id_janji_periksa',
        'tgl_periksa',
        'catatan',
        'biaya_periksa',
    ];


    protected $casts = [
        'tgl-periksa' => 'datetime',
    ];

    public function janjiPeriksa():BelongsTo
    {
        return $this->belongsTo(JanjiPeriksa::class, 'id_janji_periksa');
    }

    public function detailPeriksas():HasMany
    {
        return $this->hasMany(DetailPeriksa::class, 'id_periksa');
    }

    public function obat():BelongsTo
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

}
