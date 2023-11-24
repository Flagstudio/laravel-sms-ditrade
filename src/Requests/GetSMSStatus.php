<?php

namespace Flagstudio\LaravelSmsDitrade\Requests;

class GetSMSStatus
{
    /**
     * ID сообщений, которые запрашиваются
     *
     * @var array<int>
     */
    private array $data = [];

    private string $method = 'POST';

    private string $address = "/json/status";

    public function addID(int $id): self
    {
        $this->data[] = $id;

        return $this;
    }

    public function getRequest(): array
    {
        return [
            'data' => $this->data,
        ];
    }
}