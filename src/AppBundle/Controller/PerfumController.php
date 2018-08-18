<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bottle;
use AppBundle\Entity\Perfum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Perfum controller.
 *
 * @Route("perfum")
 */
class PerfumController extends Controller
{
    /**
     * Lists all perfum entities.
     *
     * @Route("/", name="perfum_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $perfums = $em->getRepository('AppBundle:Perfum')->findAll();

        return $this->render('perfum/index.html.twig', array(
            'perfums' => $perfums,
        ));
    }

    /**
     * Creates a new perfum entity.
     *
     * @Route("/new", name="perfum_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $perfum = new Perfum();
        $form = $this->createForm('AppBundle\Form\PerfumType', $perfum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quantity = $request->request->get('quantity');
            $perfum->setQuantity($quantity);
            $em = $this->getDoctrine()->getManager();
            $em->persist($perfum);
            $em->flush();

            return $this->redirectToRoute('homepage', array('id' => $perfum->getId()));
        }

        return $this->render('perfum/new.html.twig', array(
            'perfum' => $perfum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing perfum entity.
     *
     * @Route("/flacon/{id}/edit", name="bottle_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function bottleEditAction(Request $request, Bottle $bottle)
    {
        $editForm = $this->createForm('AppBundle\Form\BottleType', $bottle);
        $editForm->handleRequest($request);
        $quantity30ml = $bottle->getThirtyMl();
        $quantity50ml = $bottle->getFiftyMl();
        $quantity100ml = $bottle->getHundredMl();


        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $addthirtyMl = $request->request->get('add30ml');
            $addfiftyMl = $request->request->get('add50ml');
            $addhundredMl = $request->request->get('add100ml');
            $removethirtyMl = $request->request->get('remove30ml');
            $removefiftyMl = $request->request->get('remove50ml');
            $removehundredMl = $request->request->get('remove100ml');

            if ($addthirtyMl != null)
                $bottle->setThirtyMl($addthirtyMl+$quantity30ml);
            if ($addfiftyMl != null)
                $bottle->setFiftyMl($addfiftyMl+$quantity50ml);
            if ($addhundredMl != null)
                $bottle->setHundredMl($addhundredMl+$quantity100ml);
            if ($removethirtyMl != null) {
                if ($quantity30ml-$removethirtyMl<0) {
                    $this->addFlash("erreur_bottle", "Pas assez de flacon !");
                    return $this->redirectToRoute('bottle_edit', array('id' => $bottle->getId()));
                }
                $bottle->setThirtyMl($quantity30ml - $removethirtyMl);
            }
            if ($removefiftyMl != null) {
                if ($quantity50ml - $removefiftyMl < 0) {
                    $this->addFlash("erreur_bottle", "Pas assez de flacon !");
                    return $this->redirectToRoute('bottle_edit', array('id' => $bottle->getId()));
                }
                $bottle->setFiftyMl($quantity50ml - $removefiftyMl);
            }
            if ($removehundredMl != null) {
                if ($quantity100ml - $removehundredMl < 0) {
                    $this->addFlash("erreur_bottle", "Pas assez de flacon !");
                    return $this->redirectToRoute('bottle_edit', array('id' => $bottle->getId()));
                }
                $bottle->setHundredMl($quantity100ml - $removehundredMl);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage', array('id' => $bottle->getId()));

        }
        return $this->render('bottle/edit.html.twig', array(
            'bottle' => $bottle,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing perfum entity.
     *
     * @Route("/{id}/edit", name="perfum_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $perfum = $em->getRepository(Perfum::class)->find($id);
        $bottle = $em->getRepository(Bottle::class)->find(1);

        $deleteForm = $this->createDeleteForm($perfum);
        $editForm = $this->createForm('AppBundle\Form\PerfumType', $perfum);
        $editForm->handleRequest($request);
        $quantity = $perfum->getQuantity();
        $ThirtyMl = $bottle->getThirtyMl();
        $FiftyMl = $bottle->getFiftyMl();
        $HundredMl = $bottle->getHundredMl();



        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $bottleThirty = $request->request->get('nameThirty');
            $bottleFifty = $request->request->get('nameFifty');
            $bottleHundred = $request->request->get('nameHundred');
            $recharge = $request->request->get('recharge');
            $addPerfum = $request->request->get('addPerfum');

            if ($bottleThirty != null) {
                $total1 = $bottleThirty * 30;
                if (($ThirtyMl-$bottleThirty<0) || ($quantity-$total1<0)) {
                    $this->addFlash("erreur", "Pas assez de flacon ou de parfum !");
                    return $this->redirectToRoute('perfum_edit', array('id' => $perfum->getId()));
                }
            }
            else {
                $total1 = 0;
                $bottleThirty = 0;
            }

            if ($bottleFifty != null) {
                $total2 = $bottleFifty * 50;
                if (($FiftyMl-$bottleFifty<0) || ($quantity-$total2<0)) {
                    $this->addFlash("erreur", "Pas assez de flacon ou de parfum !");
                    return $this->redirectToRoute('perfum_edit', array('id' => $perfum->getId()));
                }
            }
            else {
                $total2 = 0;
                $bottleFifty = 0;
            }

            if ($bottleHundred != null) {
                $total3 = $bottleHundred *100;
                if (($HundredMl-$bottleHundred<0) || ($quantity-$total3<0)) {
                    $this->addFlash("erreur", "Pas assez de flacon ou de parfum !");
                    return $this->redirectToRoute('perfum_edit', array('id' => $perfum->getId()));
                }
            }
            else {
                $total3 = 0;
                $bottleHundred = 0;
            }

            if ($recharge ==null) {
                $recharge = 0;
            }
            elseif ($quantity-($recharge+$total1+$total2+$total3)<0){
                $this->addFlash("erreur_recharge", "Pas assez de parfum !");
                return $this->redirectToRoute('perfum_edit', array('id' => $perfum->getId()));
            }

            if ($addPerfum == null) {
                $addPerfum = 0;
            }
            $use = $total1 + $total2 + $total3 + $recharge;

            $bottleAjour30 = $ThirtyMl - $bottleThirty;
            $bottleAjour50 = $FiftyMl - $bottleFifty;
            $bottleAjour100 = $HundredMl - $bottleHundred;
            $totalAjour = $quantity - $use + $addPerfum;

            $perfum->setQuantity($totalAjour);
            $bottle->setThirtyMl($bottleAjour30);
            $bottle->setFiftyMl($bottleAjour50);
            $bottle->setHundredMl($bottleAjour100);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage', array('id' => $perfum->getId()));
        }

        return $this->render('perfum/edit.html.twig', array(
            'bottle' => $bottle,
            'perfum' => $perfum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a perfum entity.
     *
     * @Route("/{id}", name="perfum_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Perfum $perfum)
    {
        $form = $this->createDeleteForm($perfum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($perfum);
            $em->flush();
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * Creates a form to delete a perfum entity.
     *
     * @param Perfum $perfum The perfum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Perfum $perfum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('perfum_delete', array('id' => $perfum->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
