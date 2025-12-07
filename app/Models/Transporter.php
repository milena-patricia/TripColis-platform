<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transporter extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule', 'user_id', 'cni', 'permis_numero', 'telephone', 'quartier',
        'carte_grise', 'police_assurance', 'validite_assurance', 'mode_paiement',
        'frais_inscription_payes', 'statut', 'contrat_path', 'latitude', 'longitude'
    ];

    protected $casts = [
        'validite_assurance' => 'date',
        'frais_inscription_payes' => 'boolean',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    // Scopes
    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    // Méthodes
    public static function genererMatricule(): string
    {
        $prefix = 'TRP';
        $date = now()->format('Ymd');
        $count = self::where('matricule', 'like', "{$prefix}-{$date}-%")->count() + 1;
        return "{$prefix}-{$date}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function estDisponible(): bool
    {
        return $this->statut === 'actif' && 
               !$this->services()->where('statut', 'en_cours')->exists();
    }
}