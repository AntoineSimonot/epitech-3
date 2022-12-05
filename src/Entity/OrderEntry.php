<?php

namespace App\Entity;

use App\Repository\OrderEntryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderEntryRepository::class)]
class OrderEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['default'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderEntries')]
    private ?Order $client_order = null;

    #[ORM\Column(length: 255)]
    #[Groups(['default'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['default'])]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(['default'])]
    private ?int $price = null;

    #[ORM\Column]
    #[Groups(['default'])]
    private ?float $vat = null;

    #[ORM\Column(length: 255)]
    private ?string $short_description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientOrder(): ?Order
    {
        return $this->client_order;
    }

    public function setClientOrder(?Order $client_order): self
    {
        $this->client_order = $client_order;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }
}
