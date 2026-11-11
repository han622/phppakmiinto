<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'kode_tiket', 'kode_akses', 'user_id', 'category_id', 'jenis',
        'judul', 'isi', 'is_anonim', 'status', 'alasan_penolakan',
        'publish_status', 'rating', 'ulasan',
    ];

    protected $casts = ['is_anonim' => 'boolean'];

    protected $hidden = ['kode_akses'];

    public function user()        { return $this->belongsTo(User::class); }
    public function category()    { return $this->belongsTo(Category::class); }
    public function attachments() { return $this->hasMany(TicketAttachment::class); }
    public function statusLogs()  { return $this->hasMany(TicketStatusLog::class)->oldest(); }
    public function messages()    { return $this->hasMany(TicketMessage::class); }

    // Warna badge Bootstrap untuk tiap status
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'diverifikasi' => 'info',
            'diproses'     => 'warning',
            'selesai'      => 'success',
            'ditolak'      => 'danger',
            default        => 'secondary',
        };
    }
    public const TRANSISI = [
    'diajukan'     => ['diverifikasi', 'ditolak'],
    'diverifikasi' => ['diproses', 'ditolak'],
    'diproses'     => ['selesai'],
    'selesai'      => [],
    'ditolak'      => [],
];

public function statusBerikutnya(): array
{
    return self::TRANSISI[$this->status] ?? [];
}
}