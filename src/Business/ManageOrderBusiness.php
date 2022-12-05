<?php

namespace App\Business;

use App\Entity\Product;
use App\Entity\Cart;
use App\Entity\Order;

use App\Form\Model\ProductModel;
use App\Repository\ProductRepository;

class ManageOrderBusiness
{
    private ProductRepository $productRepository;

    /**
     * ManageProductBusiness constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param ProductModel $model
     *
     * @return Order
     */
    public function create(Cart $model): Order
    {
        $order = new Order();
        $order = $this->setValues($order, $model);

        return $order;
    }


    /**
     * @param OrderModel $model
     * @param Order      $order
     *
     * @return Order
     */
    private function setValues(Order $order, Cart $model): Order
    {
        $order
            ->setClient($model->getClient())
        ;

        return $order;
    }
}
