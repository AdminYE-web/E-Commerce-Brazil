<?php

namespace App\Mail;

use App\Models\User;
use App\Models\UserEmailChangeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEmailChangeVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public UserEmailChangeRequest $emailChangeRequest;
    public string $verifyUrl;

    public function __construct(User $user, UserEmailChangeRequest $emailChangeRequest, string $verifyUrl)
    {
        $this->user = $user;
        $this->emailChangeRequest = $emailChangeRequest;
        $this->verifyUrl = $verifyUrl;
    }

    public function build()
    {
        return $this->subject('Please verify your new email address')
            ->view('emails.user_email_change_verification');
    }
}
