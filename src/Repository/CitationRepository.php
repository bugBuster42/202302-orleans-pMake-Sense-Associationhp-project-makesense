<?php

namespace App\Repository;

class CitationRepository
{
    private array $citations;

    public function __construct()
    {
        $this->citations = require __DIR__ . '/../Data/citations.php';
    }

    public function findRandomCitation(): ?array
    {
        return $this->citations[array_rand($this->citations)] ?? null;
    }
}
