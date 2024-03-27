<?php

namespace App\DTO\Mails;

use App\DTO\Common\BaseDTO;

class MailDTOCollection extends \App\DTO\Common\BaseDTOCollection
{

    public function getDTOInstance(array $attributes): BaseDTO
    {
        return new MailDTO($attributes);
    }
}
