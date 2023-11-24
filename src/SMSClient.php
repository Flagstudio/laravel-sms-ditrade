<?php

namespace Flagstudio\LaravelSmsDitrade;

use Flagstudio\LaravelSmsDitrade\Contracts\SMSConfigurationInterface;
use Flagstudio\LaravelSmsDitrade\Requests\SendSMS;

class SMSClient
{
    public function __construct(
        private readonly SMSConfigurationInterface $configuration,
    ) {}

    public function send(SendSMS $request): bool|string
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->configuration->getHost() . $request->getAddress());
        curl_setopt($curl, CURLOPT_POST, 1);

        curl_setopt($curl, CURLOPT_POSTFIELDS, 'data=' . json_encode($request->getRequest()));
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_USERPWD, $this->configuration->getLogin() . ':' . $this->configuration->getPassword());
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($curl, CURLOPT_TIMEOUT_MS, 1000);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($curl);
    }
}