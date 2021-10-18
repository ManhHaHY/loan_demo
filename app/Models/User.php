<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'personal_code',
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all the loans that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loans()
    {
        return $this->hasMany(Loan::class)->latest();
    }


    /**
     * Get user BirthDate alias as formatted string
     *
     * @return date BirthDate
     */
    public function getBirthDateFormattedAttribute()
    {
        return $this->birthDate ? $this->birthDate->format('Y-m-d') : null;
    }

    /**
     * Get user BirthDate alias
     *
     * @return date BirthDate
     */
    public function getBirthDateAttribute()
    {
        if (strlen($this->personalCode) < 6) return null;
        $centuryCode = substr($this->personalCode, 0, 1);
        if ($centuryCode < 3) {
            $century = 19;
        } elseif ($centuryCode < 5) {
            $century = 20;
        } else {
            $century = 21;
        }

        $birthDate = new \DateTime(($century - 1) . substr($this->personalCode, 1, 6));
        return $birthDate;
    }

    /**
     * Get user age alias
     *
     * @return integer age
     */
    public function getAgeAttribute()
    {
        $age = $this->birthDate ? $this->birthDate->diff(new \DateTime())->y : null;
        return $age;
    }
}
