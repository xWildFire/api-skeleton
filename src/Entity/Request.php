<?php

namespace App\Entity;

use App\Repository\RequestRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequestRepository::class)]
#[ORM\Table(name: '`request`', schema: 'log')]
class Request
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $uri = null;

    #[ORM\Column(nullable: true)]
    private ?array $argument = null;

    #[ORM\Column(nullable: true)]
    private ?array $query = null;

    #[ORM\Column(nullable: true)]
    private ?array $header = null;

    #[ORM\Column]
    private string $ip;

    #[ORM\Column(nullable: true)]
    private ?array $response = null;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $finishedAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(string $uri): static
    {
        $this->uri = $uri;

        return $this;
    }

    public function getArgument(): ?array
    {
        return $this->argument;
    }

    public function setArgument(?array $argument): static
    {
        $this->argument = $argument;

        return $this;
    }

    public function getQuery(): ?array
    {
        return $this->query;
    }

    public function setQuery(?array $query): static
    {
        $this->query = $query;

        return $this;
    }

    public function getHeader(): ?array
    {
        return $this->header;
    }

    public function setHeader(?array $header): static
    {
        $this->header = $header;

        return $this;
    }

    public function getResponse(): ?array
    {
        return $this->response;
    }

    public function setResponse(?array $response): static
    {
        $this->response = $response;

        return $this;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): static
    {
        $this->ip = $ip;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFinishedAt(): ?DateTimeImmutable
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?DateTimeImmutable $finishedAt): static
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }
}
