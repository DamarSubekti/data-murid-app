<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // WAJIB ada untuk Spatie Permission
use Filament\Models\Contracts\FilamentUser; // WAJIB ada untuk Filament
use Filament\Panel; // WAJIB ada untuk parameter di canAccessPanel()

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles; // Pastikan 'HasRoles' ada di sini

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Determine if the user can access the Filament panel.
     *
     * @param  \Filament\Panel  $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Logika otorisasi untuk akses ke panel Filament:
        // Izinkan user jika mereka memiliki peran 'Admin'
        // ATAU jika mereka memiliki permission 'access_admin_panel'
        // Jika Anda hanya ingin semua user yang terautentikasi bisa akses,
        // cukup return true; atau return $this->hasAnyRole(['Admin', 'Editor Siswa', 'Viewer Siswa']);
        return $this->hasRole('Admin') ;
    }
}