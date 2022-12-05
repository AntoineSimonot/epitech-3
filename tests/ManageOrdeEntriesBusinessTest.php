<?php

namespace App\Tests;

use App\Business\ManageOrderEntriesBusiness;
use App\Entity\Order;
use App\Entity\Cart;
use App\Entity\Product;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ManageOrdeEntriesBusinessTest extends KernelTestCase
{
    public function testCreateOrderEntry(): void
    {
        $name = 'product name';
        $shortDescription = 'lorem ipsum .....';
        $quantity = 3;
        $price = 2300;
        $vat = 19.6;

        $product = new Product();
        $product->setName($name);
        $product->setShortDescription($shortDescription);
        $product->setQuantity($quantity);
        $product->setPrice($price);
        $product->setVat($vat);


        self::bootKernel();
        $manageOrderEntriesBusiness = static::getContainer()->get(ManageOrderEntriesBusiness::class);

        $order_entry = $manageOrderEntriesBusiness->create($product);

        $this->assertSame($name, $order_entry->getName());
        $this->assertSame($shortDescription, $order_entry->getShortDescription());
        $this->assertSame($quantity, $order_entry->getQuantity());
        $this->assertSame($price, $order_entry->getPrice());
        $this->assertSame($vat, $order_entry->getVat());

    }
}
