<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\AccountRole;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        $domain = config('app.filament.panel_domain');
        return str_ends_with($this->email, "@{$domain}");
    }

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Interact with the user's first name.
     */
    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => $this->emailDomainSuffix($value),
        );
    }


    private function emailDomainSuffix($value)
    {
        $panelDomainAccess = "@" . config('app.filament.panel_domain');
        $value = trim(str_ends_with($value, $panelDomainAccess)
            ? $value
            : $value . $panelDomainAccess);

        return $value;
    }
}
