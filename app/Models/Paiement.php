<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id', 'montant', 'mode_paiement', 'type_paiement',
        'preuve_paiement', 'statut'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
    ];

    // Relations
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Méthodes
    public function marquerCommePaye(): void
    {
        $this->statut = 'payé';
        $this->save();
    }
}