<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("actualite")
 */
class ActualiteController extends Controller
{
    /**
     * @Route("/", name="frontend_actualite")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Liste des trois dernieres actualites
        $actaulites = $em->getRepository('AppBundle:Actualite')->findAll();

        return $this->render('frontend/index.html.twig', [
            'actualites' => $actualites,
        ]);
    }

    /**
     * @Route("/resume", name="frontend_actualite_show")
     */
    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();
        $biographies = $em->getRepository('AppBundle:Biographie')->findAll();

        return $this->render('frontend/biographie_resume.html.twig',[
            'biographies' => $biographies,
        ]);
    }

    /**
     * @Route("/resume/accueil", name="frontend_actualite_accueil")
     */
    public function accueilAction()
    {
        $em = $this->getDoctrine()->getManager();
        $actualites = $em->getRepository('AppBundle:Actualite')->findLastActualite(3,0); //dump($actualites);die();

        return $this->render('frontend/actualite_accueil.html.twig',[
            'actualites' => $actualites,
        ]);
    }
}
