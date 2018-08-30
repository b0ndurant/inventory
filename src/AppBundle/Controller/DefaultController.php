<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Historical;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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

    /**
     * Historical
     *
     * @Route("/historique", name="historical_index")
     */
    public function historicalIndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $historical = $em->getRepository(Historical::class)->findAll();

        return $this->render('historical/index.html.twig', [
            'historicals' => $historical,
        ]);
    }

    /**
     *Truncate historical table
     *
     * @Route("/effacer-la-table", name="truncate_history")
     */
    public function truncateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository(Historical::class)->findAll();
        $count = count($test);
        $historical = new Historical();
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeUpdate($platform->getTruncateTableSQL('historical', true));
        $historical->setAction('vous avez SUPPRIMER l\'historique au bout de '.$count.' d\'historique');
        $historical->setDate(new \DateTime('now'));
        $em->persist($historical);
        $em->flush();

        return $this->redirectToRoute('historical_index');
    }
}
