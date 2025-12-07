<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_service', 'client_id', 'type_service', 'agence_voyage',
        'localite_agence', 'point_remise', 'taille_colis', 'poids_approx',
        'valeur_approx', 'fragile', 'prix_propose', 'prix_negocie',
        'statut', 'transporteur_id', 'description'
    ];

    protected $casts = [
        'poids_approx' => 'decimal:2',
        'valeur_approx' => 'decimal:2',
        'prix_propose' => 'decimal:2',
        'prix_negocie' => 'decimal:2',
        'fragile' => 'boolean',
    ];

    // Relations
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function transporteur(): BelongsTo
    {
        return $this->belongsTo(Transporter::class);
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }

    public function paiement(): HasOne
    {
        return $this->hasOne(Paiement::class);
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    // Scopes
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    public function scopeTermine($query)
    {
        return $query->where('statut', 'terminé');
    }

    // Méthodes
    public static function genererNumeroService(): string
    {
        $prefix = 'TRIP';
        $date = now()->format('Ymd');
        $count = self::where('numero_service', 'like', "{$prefix}-{$date}-%")->count() + 1;
        return "{$prefix}-{$date}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function accepterPar(Transporter $transporter, $prixNegocie = null): void
    {
        $this->transporteur_id = $transporter->id;
        $this->prix_negocie = $prixNegocie ?? $this->prix_propose;
        $this->statut = 'en_cours';
        $this->save();
    }

    public function terminer(): void
    {
        $this->statut = 'terminé';
        $this->save();
    }
}