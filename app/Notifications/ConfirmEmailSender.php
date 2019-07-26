<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail;


class ConfirmEmailSender extends VerifyEmail implements ShouldQueue
{
    use Queueable;
}
