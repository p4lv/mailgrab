<?php declare(strict_types=1);

namespace PeeHaa\MailGrab\Smtp\Response;

class ClosingTransmission extends Message
{
    public function __construct(string $message)
    {
        parent::__construct(221, $message);
    }
}
