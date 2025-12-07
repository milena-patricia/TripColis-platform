<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id', 'montant_total', 'commission_tripcolis',
        'montant_transporteur', 'date_transaction'
    ];

    protected $casts = [
        'montant_total' => 'decimal:2',
        'commission_tripcolis' => 'decimal:2',
        'montant_transporteur' => 'decimal:2',
        'date_transaction' => 'datetime',
    ];

    // Relations
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Méthodes
    public static function creerDepuisService(Service $service): self
    {
        $commission = $service->prix_negocie * 0.10; // 10% de commission
        $montantTransporteur = $service->prix_negocie - $commission;

        return self::create([
            'service_id' => $service->id,
            'montant_total' => $service->prix_negocie,
            'commission_tripcolis' => $commission,
            'montant_transporteur' => $montantTransporteur,
            'date_transaction' => now(),
        ]);
    }
}