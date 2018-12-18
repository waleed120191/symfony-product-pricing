<?php

namespace App\Controller\Front;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Enum\PlEnum;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("front/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_front__index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('front/product/index.html.twig', ['products' => $productRepository->findAll()]);
    }

    /**
     * @Route("/checkout", name="product_front_checkout", methods={"GET"})
     */
    public function checkout(Request $request): Response
    {
        $get = $request->query->all();
        $products = $get['products'];

        $return = [];
        $gt = 0;
        foreach($products as $product){
            $repository = $this->getDoctrine()->getRepository(Product::class);
            $db_product = $repository->find($product['p_id']);

            $product_quantity = $product['qty'];
            $product_price = $db_product->getPrice();

            if($db_product->getPricingRule()){
                $pricing_rule_type = $db_product->getPricingRule()->getType();
                $pricing_rule_quantity = $db_product->getPricingRule()->getQuantity();
                $pricing_rule_amount = $db_product->getPricingRule()->getAmount();


                if($pricing_rule_type == PlEnum::TYPE_FOR){

                    $n = $product_quantity/$pricing_rule_quantity;
                    $whole = floor($n);
                    $fraction = $n - $whole;

                    $f_discounted_amount = $whole*$pricing_rule_amount;
                    $f_other_amout = ($fraction*$pricing_rule_quantity) * $product_price;

                    $f_total = $f_discounted_amount + $f_other_amout;

                    $return[] = [ 'product' => $db_product->getName() ,'product_total' => $f_total ];
                    $gt += $f_total;
                }

                elseif($pricing_rule_type == PlEnum::TYPE_KG){
                    $kg_total = $product_price * $product_quantity;

                    $return[] = [ 'product' => $db_product->getName() ,'product_total' => $kg_total ];
                    $gt += $kg_total;
                }

                elseif($pricing_rule_type == PlEnum::TYPE_BUY_GET_FREE){
                    $n = $product_quantity/$pricing_rule_quantity;
                    $whole = floor($n);

                    if($product_quantity%$pricing_rule_quantity == 0){
                        $whole = $whole  - 1;
                    }

                    $f_discounted_qyt = $whole*$pricing_rule_amount;

                    $bgf_total = ($product_quantity - $f_discounted_qyt) * $product_price;

                    $return[] = [ 'product' => $db_product->getName() ,'product_total' => $bgf_total ];
                    $gt += $bgf_total;
                }
            }else{
                $else_total = $product_price * $product_quantity;

                $return[] = [ 'product' => $db_product->getName() ,'product_total' => $else_total ];
                $gt += $else_total;
            }

        }

        $return['grand_total'] = $gt;

        $response = new JsonResponse($return);
        return $response;
    }




}
