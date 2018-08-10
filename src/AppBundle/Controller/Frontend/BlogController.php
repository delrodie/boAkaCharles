<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("blog")
 */
class BlogController extends Controller
{
    /**
     * @Route("/", name="frontend_blog")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Liste des trois dernieres actualites
        $articles = $em->getRepository('AppBundle:Post')->findBy(array('statut' => 1), array('id'=>'DESC'), 5, 0);

        return $this->render('frontend/blogs.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{slug}", name="frontend_blog_show")
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $actualite = $em->getRepository('AppBundle:Post')->findOneBy(array('slug'=>$slug));

        return $this->render('frontend/blog_show.html.twig',[
            'actualite' => $actualite,
        ]);
    }

    /**
     * @Route("/menu/article", name="frontend_blog_menu")
     */
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Post')->findBy(array('statut'=>1), array('id'=>'DESC'), 4, 0); //dump($actualites);die();

        return $this->render('frontend/blog_menu.html.twig',[
            'articles' => $articles,
        ]);
    }
}
