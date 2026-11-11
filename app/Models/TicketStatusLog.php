<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketStatusLog extends Model
{
    protected $fillable = ['ticket_id', 'changed_by', 'status', 'catatan'];
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}