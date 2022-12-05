<?php 

namespace App\EventListener;

use App\Entity\Product;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class UpdatedPriceListener
{
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    // the entity listener methods receive two arguments:
    // the entity instance and the lifecycle event
    public function preUpdate(Product $product, PreUpdateEventArgs $event): void
    {
        echo "preUpdate";
       dd($event);

    }
}