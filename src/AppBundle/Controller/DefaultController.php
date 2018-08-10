<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Liste des trois dernieres actualites
        $actualites = $em->getRepository('AppBundle:Post')->findBy(array('statut'=>1), array('id'=>'DESC'), 3, 0);

        return $this->render('default/index.html.twig', [
            'actualites' => $actualites,
        ]);
    }

    /**
     * @Route("/backend/tableau-de-bord", name="backend")
     * @Security("has_role('ROLE_AUTEUR')")
     */
    public function backendAction()
    {
        return $this->render('default/backend.html.twig');
    }
}
