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
        $actualites = $em->getRepository('AppBundle:Actualite')->findBy(array('statut' => 1), array('id'=>'DESC'), 5, 0);

        return $this->render('frontend/actualites.html.twig', [
            'actualites' => $actualites,
        ]);
    }

    /**
     * @Route("/{slug}", name="frontend_actualite_show")
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $actualite = $em->getRepository('AppBundle:Actualite')->findOneBy(array('slug'=>$slug));
        $similaires = $em->getRepository('AppBundle:Actualite')->findSimilaires($slug, 2, 0);

        return $this->render('frontend/actualite_show.html.twig',[
            'actualite' => $actualite,
            'similaires' => $similaires,
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
