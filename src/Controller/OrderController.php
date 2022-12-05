<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\Type\OrderType;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function list(Request $request): Response
    {
        $client_id = $request->get('client_id');
        $orders = $this->orderRepository->findByClientId($client_id);
        return $this->buildDataResponse($orders);
    }

    public function single(int $id): Response
    {
        $order = $this->orderRepository->find($id);

        if ($order === null) {
            return $this->buildNotFoundResponse();
        }

        return $this->buildDataResponse($order);
    }

    public function update(Request $request, int $id) : Response
    {
        $order = $this->orderRepository->find($id);

        if ($order === null) {
            return $this->buildNotFoundResponse();
        }

        $form = $this->createForm(
            orderType::class,
            $order,
            ['method' => 'PUT']
        );

        $parameters = json_decode($request->getContent(), true);
        $form->submit($parameters);

        if (!$form->isValid()) {
            return $this->buildFormErrorResponse($form);
        }

        $this->orderRepository->save($order, true);

        return $this->buildDataResponse($order);
    }

    public function add(Request $request) : Response
    {
        $order = new order();

        $form = $this->createForm(
            orderType::class,
            $order,
            ['method' => 'POST']
        );

        $parameters = json_decode($request->getContent(), true);
        $form->submit($parameters);

        if (!$form->isValid()) {
            return $this->buildFormErrorResponse($form);
        }

        $this->orderRepository->save($order, true);

        return $this->buildDataResponse($order);
    }

    public function delete(int $id) : Response
    {
        $order = $this->orderRepository->find($id);

        if ($order === null) {
            return $this->buildNotFoundResponse();
        }

        $this->orderRepository->remove($order, true);

        return $this->buildEmptyResponse();
    }
}
