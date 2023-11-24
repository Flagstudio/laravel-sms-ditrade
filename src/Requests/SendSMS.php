<?php

namespace Flagstudio\LaravelSmsDitrade\Requests;

/**
 * Отправка СМС - POST - http://sms-gate.ditrade.ru/sm - BASIC AUTH
 * Content-Type: application/x-www-form-urlencoded
 */
class SendSMS
{
    /**
     * @var array
     */
    private array $phones = [];

    /**
     * @var string
     */
    private string $message;

    /**
     * Отправитель сообщения, как он будет выглядеть на телефоне получателя.
     * Отправитель может быть только одним из присвоенных клиенту
     *
     * @var string
     */
    private string $originator;

    private string $method = 'POST';

    private string $address = "/regular/sm";

    public function __construct(string $message, string $originator)
    {
        $this->message = $message;
        $this->originator = $originator;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function addPhone(string $phone): self
    {
        if (str_starts_with($phone, '+')) {
            $phone = mb_substr($phone, 1);
        }

        $this->phones[] = $phone;

        return $this;
    }

    public function getRequest(): string
    {
        $phones = '[';

        foreach ($this->phones as $phone) {
            $phones .= $phone . ',';
        }

        return sprintf('&%s=%s&%s=%s&%s=%s',
            'phones', $phones . ']',
            'message', $this->message,
            'originator', $this->originator,
        );
    }
}