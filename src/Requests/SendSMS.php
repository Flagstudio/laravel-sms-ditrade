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

    private string $address = "/json/sm";

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
        $this->phones[] = $phone;

        return $this;
    }

    public function getRequest(): array
    {
        return [
            'phones' => $this->phones,
            'message' => $this->message,
            'originator' => $this->originator,
        ];
    }
}