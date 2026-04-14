<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * User Model - Mewakili pengguna sistem (ASN, PIMPINAN, ADMIN)
 * 
 * Model ini merepresentasikan semua pengguna dalam sistem KPDT Demo.
 * Setiap user memiliki role (ASN/PIMPINAN/ADMIN) dan terkait dengan wilayah dan OPD tertentu.
 * 
 * @property int $id - ID unik user
 * @property string $name - Nama lengkap user
 * @property string $email - Email user
 * @property string $nip - Nomor Induk Pegawai (unik untuk ASN)
 * @property int $wilayah_id - ID wilayah user bekerja
 * @property int $opd_id - ID OPD (Organisasi Perangkat Daerah) user
 * @property string $password - Password yang ter-hash
 * @property boolean $is_flagged - Status flagged user (underperforming)
 * @property datetime $flagged_at - Waktu user di-flag
 * @property string $posting_count_this_month - Jumlah posting bulan ini (relasi)
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'nip',
        'wilayah_id',
        'opd_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the Wilayah this user belongs to.
     */
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }

    /**
     * Get the OPD this user belongs to.
     */
    public function opd()
    {
        return $this->belongsTo(OPD::class);
    }

    /**
     * Get postings by this user.
     */
    public function postings()
    {
        return $this->hasMany(Posting::class);
    }

    /**
     * Get evaluations for this user.
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * Get evaluations given by this user (pimpinan).
     */
    public function evaluationsDone()
    {
        return $this->hasMany(Evaluation::class, 'evaluated_by');
    }

    /**
     * Get semua notifikasi user
     * Digunakan untuk menampilkan notification bell dan notifikasi page
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }

    /**
     * Hitung jumlah notifikasi yang belum dibaca
     * Digunakan untuk notification badge di navbar
     * 
     * @return int
     */
    public function unreadNotificationsCount()
    {
        return $this->notifications()->unread()->count();
    }

    /**
     * Cek apakah user sedang dalam status flagged (underperforming)
     * User di-flag otomatis jika posting < 4 dalam satu bulan
     * 
     * @return bool
     */
    public function isFlagged()
    {
        return $this->is_flagged === true;
    }

    /**
     * Get current month evaluation.
     */
    public function currentEvaluation()
    {
        return $this->evaluations()
            ->where('evaluation_month', '>=', now()->startOfMonth())
            ->where('evaluation_month', '<', now()->addMonth()->startOfMonth())
            ->first();
    }

    /**
     * Cek apakah user memiliki notifikasi yang belum dibaca
     */
    public function hasUnreadNotifications()
    {
        return $this->notifications()->unread()->exists();
    }

    /**
     * Get roles (inherited from Spatie).
     */
    protected static function boot()
    {
        parent::boot();
    }
}
