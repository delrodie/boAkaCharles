<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("biographie")
 */
class BiographieController extends Controller
{
    /**
     * @Route("/", name="frontend_biographie")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Liste des trois dernieres actualites
        $biographie = $em->getRepository('AppBundle:Biographie')->findAll();

        return $this->render('frontend/index.html.twig', [
            'biographies' => $biographies,
        ]);
    }

    /**
     * @Route("/resume", name="frontend_biographie_resume")
     */
    public function resumeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $biographies = $em->getRepository('AppBundle:Biographie')->findAll();

        return $this->render('frontend/biographie_resume.html.twig',[
            'biographies' => $biographies,
        ]);
    }

    /**
     * @Route("/{slug}", name="frontend_biographie_show")
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $biographie = $em->getRepository('AppBundle:Biographie')->findOneBy(array('slug'=>$slug));

        return $this->render('frontend/biographie_show.html.twig', [
            'biographie' => $biographie,
        ]);
    }

    /**
     * @Route("/resume/footer", name="frontend_biographie_footer")
     */
    public function footerAction()
    {
        $em = $this->getDoctrine()->getManager();
        $biographies = $em->getRepository('AppBundle:Biographie')->findAll();

        return $this->render('frontend/biographie_footer.html.twig',[
            'biographies' => $biographies,
        ]);
    }
}
