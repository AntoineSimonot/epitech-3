<?php

namespace App\Controller;

use App\Business\ManagecartBusiness;
use App\Entity\Cart;
use App\Form\Model\AbstractPaginationModel;
use App\Form\Model\cartModel;
use App\Entity\Order;
use App\Entity\OrderEntry;

use App\Form\Model\cartSearchModel;
use App\Form\Type\cartSearchType;
use App\Form\Type\cartType;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;

// order repository
use App\Repository\OrderRepository;
// order entry repository
use App\Repository\OrderEntryRepository;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use App\Business\ManageOrderEntriesBusiness;
use App\Business\ManageOrderBusiness;

class CartController extends AbstractController
{
    const CONTEXT = 'cart';

    private CartRepository $cartRepository;
    private ProductRepository $productRepository;

    public function __construct(CartRepository $cartRepository, ProductRepository $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }
  

  

    /**
     * @OA\Response(
     *     response=201,
     *     description="Create a Complainant resources",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=cart::class))
     *     )
     * ),
     *  @OA\Response(
     *     response=401,
     *     description= "Authentication error, you are not allowed to access this url"
     * ),
     *  @OA\Response(
     *     response=400,
     *     description= "Form error"
     * ),
     * @OA\RequestBody(
     *      @OA\JsonContent(
     *          type="object",
     *          ref=@Model(type=cartType::class)
     *      )
     * )
     * @OA\Tag(name="cart")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param ManagecartBusiness $managecartBusiness
     * @return Response
     */
    public function add(Request $request, ManagecartBusiness $managecartBusiness): Response
    {
        $model = new cartModel();

        $form = $this->createForm(
            cartType::class,
            $model,
            ['method' => 'POST']
        );

        $parameters = json_decode($request->getContent(), true);
        $form->submit($parameters);
        if (!$form->isValid()) {
            return $this->buildFormErrorResponse($form);
        }

        $cart = $managecartBusiness->create($model);
        $this->cartRepository->save($cart, true);

        return $this->buildDataResponse($cart, self::CONTEXT);

    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Modify an Complainant resources",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=cart::class))
     *     )
     * ),
     *  @OA\Response(
     *     response=401,
     *     description= "Authentication error, you are not allowed to access this url"
     * ),
     *  @OA\Response(
     *     response=400,
     *     description= "Form error"
     * ),
     * @OA\RequestBody(
     *      @OA\JsonContent(
     *          type="object",
     *          ref=@Model(type=cartType::class)
     *      )
     * )
     * @OA\Tag(name="cart")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param cart $cart
     * @param ManagecartBusiness $managecartBusiness
     * @return Response
     */
    public function update(Request $request, cart $cart, ManagecartBusiness $managecartBusiness): Response
    {
        $model = new cartModel();
        $form = $this->createForm(
            cartType::class,
            $model,
            ['method' => 'PUT']
        );

        $parameters = json_decode($request->getContent(), true);
        $form->submit($parameters);
        if (!$form->isValid()) {
            return $this->json(null, );
        }

        try {
            $managecartBusiness->update($model, $cart);
            $this->cartRepository->save($cart);

            return $this->buildDataResponse($cart, self::CONTEXT);

        } catch (Exception $exception) {
            return $this->buildErrorResponse($exception);
        }
    }

    /**
     * @OA\Response(
     *     response=204,
     *     description="Remove cart resource from its unique identifier",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=cart::class))
     *     )
     * ),
     * @OA\Response(
     *     response=404,
     *     description="cart not found",
     * ),
     *  @OA\Response(
     *     response=401,
     *     description= "Authentication error, you are not allowed to access this url"
     * )
     * @OA\Tag(name="cart")
     * @Security(name="Bearer")
     * @param cart $cart
     *
     * @return JsonResponse
     */
    public function delete(cart $cart): Response
    {
        $this->cartRepository->remove($cart, true);
        return $this->buildEmptyResponse();
    }

    // remove product from cart
    /**
     * @OA\Response(
     *     response=204,
     *     description="Remove cart resource from its unique identifier",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=cart::class))
     *     )
     * ),
     * @OA\Response(
     *     response=404,
     *     description="cart not found",
     * ),
     *  @OA\Response(
     *     response=401,
     *     description= "Authentication error, you are not allowed to access this url"
     * )
     * @OA\Tag(name="cart")
     * @Security(name="Bearer")
     * @param cart $cart
     *
     * @return JsonResponse
     */

    public function removeProduct(Request $request): Response
    {
        $product = $this->productRepository->find($request->get('product_id'));
        $cart = $this->cartRepository->find($request->get('cart_id'));

        $cart->removeProduct($product);

        $this->cartRepository->save($cart, true);
        return $this->buildEmptyResponse();
    }  
    
    // add product to cart
    /**
     * @OA\Response(
     *     response=204,
     *     description="Remove cart resource from its unique identifier",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=cart::class))
     *     )
     * ),
     * @OA\Response(
     *     response=404,
     *     description="cart not found",
     * ),
     *  @OA\Response(
     *     response=401,
     *     description= "Authentication error, you are not allowed to access this url"
     * )
     * @OA\Tag(name="cart")
     * @Security(name="Bearer")
     * @param cart $cart
     *
     * @return JsonResponse
     */

    public function addProduct(Request $request): Response
    {
        $product_id = $request->get('product_id');

        $cart = $this->cartRepository->find($request->get('cart_id'));


        $product = $this->productRepository->find($product_id);
        $cart->addProduct($product);
        $this->cartRepository->save($cart, true);
        return $this->buildEmptyResponse();
    }

    // validate cart
    /**
     * @OA\Response(
     *     response=204,
     *     description="Remove cart resource from its unique identifier",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=cart::class))
     *     )
     * ),
     * @OA\Response(
     *     response=404,
     *     description="cart not found",
     * ),
     *  @OA\Response(
     *     response=401,
     *     description= "Authentication error, you are not allowed to access this url"
     * )
     * @OA\Tag(name="cart")
     * @Security(name="Bearer")
     * @param cart $cart
     *
     * @return JsonResponse
     */

    public function validate(Request $request, OrderRepository $orderRepository, OrderEntryRepository $orderEntryRepository, CartRepository $cartRepository, ManageOrderEntriesBusiness $manageOrderEntriesBusiness, ManageOrderBusiness $manageOrderBusiness): Response
    {
        $cart = $this->cartRepository->find($request->get('cart_id'));

        $order = $manageOrderBusiness->create($cart);

        $cart_products = $cart->getProducts();
        for ($i = 0; $i < count($cart_products); $i++) {
            $order_entry = $manageOrderEntriesBusiness->create($cart_products[$i]);
    
            $order->addOrderEntry($order_entry);
            $orderEntryRepository->save($order_entry);
        }

        
        $orderRepository->save($order, true);
        // $cartRepository->remove($cart, true);
        return $this->buildEmptyResponse();
    }
}
