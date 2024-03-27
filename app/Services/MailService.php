<?php

namespace App\Services;

use App\DTO\Mails\MailDTO;
use App\DTO\Mails\MailDTOCollection;
use App\Services\Common\ServiceResult;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendMails(MailDTOCollection $mailDTOCollection): ServiceResult
    {
        foreach ($mailDTOCollection->getItems() as $mailDTO) {
            /** @var MailDTO $mailDTO */
            $sendMailServiceResult = $this->sendMail($mailDTO);

            if ($sendMailServiceResult->isError) {
                return $sendMailServiceResult;
            }
        }

        return ServiceResult::createSuccessResult('Письма успешно отправлены');
    }

    public function sendMail(MailDTO $mailDTO): ServiceResult
    {
        try {
            Mail::to($mailDTO->emailAddress)->send($mailDTO->mail);

            return ServiceResult::createSuccessResult('Письмо успешно отправлено');
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage(), [
                $exception->getFile(),
                $exception->getTrace(),
            ]);

            return ServiceResult::createErrorResult('Не удалось отправить письмо');
        }
    }
}
