<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['default'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[Groups(['default'])]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'client_order', targetEntity: OrderEntry::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['default'])]
    private Collection $orderEntries;

    public function __construct()
    {
        $this->orderEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function validate(?Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return Collection<int, OrderEntry>
     */
    public function getOrderEntries(): Collection
    {
        return $this->orderEntries;
    }

    public function addOrderEntry(OrderEntry $orderEntry): self
    {
        if (!$this->orderEntries->contains($orderEntry)) {
            $this->orderEntries->add($orderEntry);
            $orderEntry->setClientOrder($this);
        }

        return $this;
    }

    public function removeOrderEntry(OrderEntry $orderEntry): self
    {
        if ($this->orderEntries->removeElement($orderEntry)) {
            // set the owning side to null (unless already changed)
            if ($orderEntry->getClientOrder() === $this) {
                $orderEntry->setClientOrder(null);
            }
        }

        return $this;
    }

    // setUSer
    
    public function setClient(?Client $client): self
    {
        $this->client = $client;
        return $this;
    }
}
