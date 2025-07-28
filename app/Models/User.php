<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements ContractsAuditable
{
    use HasApiTokens, HasFactory, Notifiable, Auditable, HasRoles, ModelTrait;

    protected $searchField = ['name','email'];
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
    ];

   public function scopeNotSuperAdmin($query, $value = true)
    {
        if (!$value) return $query;

        return $query->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'superadmin');
        });
    }

    protected function labelRole(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->roles->first()?->name,
        );
    }
}
