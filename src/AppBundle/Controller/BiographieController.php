<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Biographie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
                                                           
use AppBundle\Utils\Utilities;

/**
 * Biographie controller.
 *
 * @Route("backend/biographie")
 */
class BiographieController extends Controller
{
    /**
     * Lists all biographie entities.
     *
     * @Route("/", name="backend_biographie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $biographies = $em->getRepository('AppBundle:Biographie')
                          ->findBy(
                            array('statut'=> 1),
                            array('id' => 'DESC'),
                            1, 0
                          );

        return $this->render('biographie/index.html.twig', array(
            'biographies' => $biographies,
        ));
    }

    /**
     * Creates a new biographie entity.
     *
     * @Route("/new", name="backend_biographie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $biographie = new Biographie();
        $form = $this->createForm('AppBundle\Form\BiographieType', $biographie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($biographie->getContenu(), 300, '...', true);
            $biographie->setResume($resume); //dump($biographie);die();
            $em->persist($biographie);
            $em->flush(); 

            return $this->redirectToRoute('backend_biographie_index');
        }

        return $this->render('biographie/new.html.twig', array(
            'biographie' => $biographie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a biographie entity.
     *
     * @Route("/{id}", name="backend_biographie_show")
     * @Method("GET")
     */
    public function showAction(Biographie $biographie)
    {
        $deleteForm = $this->createDeleteForm($biographie);

        return $this->render('biographie/show.html.twig', array(
            'biographie' => $biographie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing biographie entity.
     *
     * @Route("/{slug}/edit", name="backend_biographie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Biographie $biographie, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($biographie);
        $editForm = $this->createForm('AppBundle\Form\BiographieType', $biographie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($biographie->getContenu(), 300, '...', true);
            $biographie->setResume($resume); //dump($biographie);die();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_biographie_index');
        }

        return $this->render('biographie/edit.html.twig', array(
            'biographie' => $biographie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a biographie entity.
     *
     * @Route("/{id}", name="backend_biographie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Biographie $biographie)
    {
        $form = $this->createDeleteForm($biographie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($biographie);
            $em->flush();
        }

        return $this->redirectToRoute('backend_biographie_index');
    }

    /**
     * Creates a form to delete a biographie entity.
     *
     * @param Biographie $biographie The biographie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Biographie $biographie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_biographie_delete', array('id' => $biographie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
