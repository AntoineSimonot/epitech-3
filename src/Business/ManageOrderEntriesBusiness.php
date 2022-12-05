<?php

namespace App\Business;

use App\Entity\Product;
use App\Entity\OrderEntry;

use App\Form\Model\ProductModel;
use App\Repository\OrderEntryRepository;

class ManageOrderEntriesBusiness
{
    private OrderEntryRepository $orderEntryRepository;

    /**
     * ManageProductBusiness constructor.
     *
     * @param OrderEntryRepository $orderEntryRepository
     */
     
    public function __construct(OrderEntryRepository $orderEntryRepository)
    {
        $this->orderEntryRepository = $orderEntryRepository;
    }
  
       /**
     * @param OrderEntry $orderEntry
     *
     * @return OrderEntry
     
     */
      /**
     * @param ProductModel $model
     *
     * @return Product
     */
    public function create(Product $model): OrderEntry
    {
        $orderEntry = new OrderEntry();
        $orderEntry = $this->setValues($model, $orderEntry);

        return $orderEntry;
    }



    /**
     * @param OrderEntryModel $model
     * @param OrderEntry      $product
     *
     * @return OrderEntry
     */
    public function setValues(Product $model, OrderEntry $orderEntry): OrderEntry
    {
        $orderEntry
            ->setName($model->getName())
            ->setQuantity($model->getQuantity())
            ->setVat($model->getVat())
            ->setShortDescription($model->getShortDescription())
            ->setPrice($model->getPrice())
        ;
        

        return $orderEntry;
    }
}
