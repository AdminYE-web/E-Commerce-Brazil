<?php

namespace App\Models;

use App\Notifications\VerifyEmailCustom;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $primaryKey = 'user_id';

   protected $fillable = [
    'first_name',
    'last_name',
    'name',
    'email',
    'phone',
    'password',
    'avatar',
    'status',
    'term_policy',
    'receive_email',
    'email_verified_at',
    'last_login_at',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

  protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'term_policy' => 'boolean',
        'receive_email' => 'boolean',
    ];
}

   public function sendEmailVerificationNotification()
{
    $url = URL::temporarySignedRoute(
        'verification.verify',
        Carbon::now()->addMinutes(5),
        [
            'id' => $this->user_id,
            'hash' => sha1($this->email),
        ]
    );

    $this->notify(new VerifyEmailCustom($url));
}

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class, 'user_id', 'user_id');
    }
}