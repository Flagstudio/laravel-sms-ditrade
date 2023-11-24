<?php

namespace Flagstudio\LaravelSmsDitrade\Contracts;

interface SMSConfigurationInterface
{
    public function getHost(): string;

    public function getLogin(): string;

    public function getPassword(): string;
}