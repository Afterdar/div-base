<?php

namespace App\DTO\Mails;

use Illuminate\Mail\Mailable;

class MailDTO extends \App\DTO\Common\BaseDTO
{
    public function __construct(
        readonly string   $emailAddress,
        readonly Mailable $mail
    )
    {
    }
}
