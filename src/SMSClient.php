<?php

namespace Flagstudio\LaravelSmsDitrade;

use Flagstudio\LaravelSmsDitrade\Contracts\SMSConfigurationInterface;
use Flagstudio\LaravelSmsDitrade\Requests\GetSMSStatus;
use Flagstudio\LaravelSmsDitrade\Requests\SendSMS;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

class SMSClient
{
    public function __construct(
        private readonly SMSConfigurationInterface $configuration,
        private readonly ClientInterface $client,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly UriFactoryInterface $uriFactory,
        private readonly StreamFactoryInterface $streamFactory,
    ) {}

    /**
     * @throws ClientExceptionInterface
     */
    public function send(SendSMS $request): ResponseInterface
    {
        $uri = $this->uriFactory->createUri(
            $this->configuration->getHost() . $request->getAddress()
        );

        $data = $this->streamFactory->createStream(
            json_encode($request->getRequest())
        );

        $request = $this->requestFactory
            ->createRequest($request->getMethod(), $uri)
            ->withHeader(
                'Authorization',
                'Basic ' . $this->configuration->getLogin() . ":" . $this->configuration->getPassword()
            )
            ->withHeader("Content-Type", "application/x-www-form-urlencoded")
            ->withBody($data)
        ;

        return $this->client->sendRequest($request);
    }

    public function status(GetSMSStatus $request): ResponseInterface
    {
        // TODO
    }
}