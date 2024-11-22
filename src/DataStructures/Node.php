<?php

declare(strict_types=1);

namespace App\DataStructures;

class Node
{
    private int|string $data;
    private ?Node $next = null;

    public function __construct(string|int $data, ?Node $next = null)
    {
        $this->data = $data;
        $this->next = $next;
    }

    public function setData(string|int $data): void
    {
        $this->data = $data;
    }

    public function getData(): string|int
    {
        return $this->data;
    }

    public function setNext(?Node $next): void
    {
        $this->next = $next;
    }

    public function getNext(): ?Node
    {
        return $this->next;
    }
}
