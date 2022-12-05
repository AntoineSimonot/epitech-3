<?php

namespace App\Tests;

use App\Business\ManageOrderBusiness;
use App\Entity\Order;
use App\Entity\Cart;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ManageOrderBusinessTest extends KernelTestCase
{
    public function testCreateOrder(): void
    {
        $client = new Client();
        $cart = new Cart();

        $cart->setClient($client);

        self::bootKernel();
        $manageProductBusiness = static::getContainer()->get(ManageOrderBusiness::class);

        $order = $manageProductBusiness->create($cart);


        $this->assertSame($client, $order->getClient());
    }
}
