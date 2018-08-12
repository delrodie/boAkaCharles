<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Citation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Citation controller.
 *
 * @Route("backend/citation")
 */
class CitationController extends Controller
{
    /**
     * Lists all citation entities.
     *
     * @Route("/", name="backend_citation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $citations = $em->getRepository('AppBundle:Citation')->findCitationDESC();

        return $this->render('citation/index.html.twig', array(
            'citations' => $citations,
        ));
    }

    /**
     * Creates a new citation entity.
     *
     * @Route("/new", name="backend_citation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $citation = new Citation();
        $form = $this->createForm('AppBundle\Form\CitationType', $citation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($citation);
            $em->flush();

            return $this->redirectToRoute('backend_citation_index');
        }

        return $this->render('citation/new.html.twig', array(
            'citation' => $citation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a citation entity.
     *
     * @Route("/{id}", name="backend_citation_show")
     * @Method("GET")
     */
    public function showAction(Citation $citation)
    {
        $deleteForm = $this->createDeleteForm($citation);

        return $this->render('citation/show.html.twig', array(
            'citation' => $citation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing citation entity.
     *
     * @Route("/{id}/edit", name="backend_citation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Citation $citation)
    {
        $deleteForm = $this->createDeleteForm($citation);
        $editForm = $this->createForm('AppBundle\Form\CitationType', $citation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_citation_index');
        }

        return $this->render('citation/edit.html.twig', array(
            'citation' => $citation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a citation entity.
     *
     * @Route("/{id}", name="backend_citation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Citation $citation)
    {
        $form = $this->createDeleteForm($citation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($citation);
            $em->flush();
        }

        return $this->redirectToRoute('backend_citation_index');
    }

    /**
     * Creates a form to delete a citation entity.
     *
     * @param Citation $citation The citation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Citation $citation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_citation_delete', array('id' => $citation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
