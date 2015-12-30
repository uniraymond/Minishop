<?php
/**
 * Created by PhpStorm.
 * User: raymond
 * Date: 26/12/15
 * Time: 10:07 PM
 */


namespace Minishop\ShopBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ProductApiController extends FOSRestController
//class ProductApiController extends Controller
{
//  public function getProductsAction()
//  {
//    $em = $this->getDoctrine()->getManager();
//    $entity = $em->getRepository('MinishopShopBundle:Product')->findAll();
//
////        $data = $this->get('jms_serializer')->serialize($entity, 'json');
//
////        return new Response(
////            $data, 200, array('Content-Type'=>'application/json')
////        );
//    $view = $this->view($entity, 200)
//        ->setTemplate('MinishopShopBundle:ProductApi:getProducts.html.twig')
//        ->setTemplateVar('products');
//////        return $this->render('MinishopShopBundle:ProductApi:getProducts.html.twig', array(
//////                // ...
//////            ));
//    return $this->handleView($view);
//  }

  /**
   * @Route("/api/get_product_by_id/{product_id}",requirements={"product_id"="\d+"})
   * @Method("GET")
   * @ApiDoc(
   *  resource=true,
   *  description="get product by product_id",
   *  filters={
   *      {"name"="product_id", "dataType"="integer"}
   *  }
   * )
   */
  public function getProductByIdAction($product_id)
  {
    $serializer = $this->container->get('jms_serializer');

    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('MinishopShopBundle:Product')->find($product_id);
//    $entity = $em->getRepository('MinishopShopBundle:Product')->findById($product_id);

//    $array_data = array('product' => $entity);
//    var_dump($serializer->serialize($array_data, 'json'));exit;
    $array_data = array('id'=> $entity->getId(), 'name'=>$entity->getName(), 'price'=>$entity->getPrice(),
        'brand'=>$entity->getBrand(),
        'description'=>$entity->getDescription());
//    var_dump($serializer->serialize($entity[0], 'json'));exit;
    return new Response($serializer->serialize($array_data, 'json'));
  }
}