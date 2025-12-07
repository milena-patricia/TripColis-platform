<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'code_ticket', 'date_emission', 'date_validation'];

    protected $casts = [
        'date_emission' => 'datetime',
        'date_validation' => 'datetime',
    ];

    // Relations
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Méthodes
    public static function genererCodeTicket(): string
    {
        return 'TICKET-' . strtoupper(uniqid());
    }

    public function valider(): void
    {
        $this->date_validation = now();
        $this->save();
    }
}