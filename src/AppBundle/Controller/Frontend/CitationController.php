<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("citation")
 */
class CitationController extends Controller
{
    /**
     * @Route("/", name="frontend_citation")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Liste des six dernieres citations
        $citations = $em->getRepository('AppBundle:Citation')->findBy(array('statut' => 1), array('id'=>'DESC'), 5, 0);

        return $this->render('frontend/citation.html.twig', [
            'citations' => $citations,
        ]);
    }
}
