<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Perfum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $perfums = $em->getRepository('AppBundle:Perfum')->findBy([],['quantity'=> 'asc']);
        $bottles = $em->getRepository('AppBundle:Bottle')->findAll();

        return $this->render('default/index.html.twig', [
            'perfums' => $perfums,
            'bottles' => $bottles,
        ]);
    }
}
