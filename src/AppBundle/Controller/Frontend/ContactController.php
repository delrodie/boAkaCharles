<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("contact")
 */
class ContactController extends Controller
{
    /**
     * @Route("/", name="frontend_contact")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Liste des trois dernieres actualites

        return $this->render('frontend/contact.html.twig');
    }

    /**
     * @Route("/mail", name="frontend_contact_mail")
     * @Method({"GET", "POST"})
     */
    public function mailAction(Request $request, \Swift_Mailer $mailer)
    {
        $nom = $request->get('name');
        $email = $request->get('email');
        $objet = $request->get('subject');
        $observation = $request->get('message');

        $message = (new \Swift_Message($objet))
                    ->setFrom(['noreply@akacharles.com' => 'AKA CHARLES'])
                    //->setTo($partenaire)
                    ->setTo(['ablokov@yahoo.fr', 'contact@akacharles.com'])
                    //->setTo(['delrodieamoikon@gmail.com', 'delrodieamoikon@outlook.fr'])
                    //->setBcc(['info@alloimmo.ci', 'delrodieamoikon@gmail.com'])
                    ->setBcc('delrodieamoikon@gmail.com')
                    ->setReplyTo($email)
                    ->setBody(
                        $this->renderView(
                          'frontend/contact_mail.html.twig',[
                            'nom' => $nom,
                            'email' => $email,
                            'objet' => $objet,
                            'observation' => $observation,
                          ]
                        ), 'text/html'
                      )
        ;

        if ($mailer->send($message)) {
            $this->addFlash('notice', 'Votre message a bien été envoyé !?');
            return $this->redirectToRoute('homepage');
        } else {
            $this->addFlash('erreur', 'ne sommes desolé votre message n\'a pas pu être envoyé');
        }

        /*return $this->render('frontend/contact_mail.html.twig',[
            'nom' => $nom,
            'email' => $email,
            'objet' => $objet,
            'observation' => $observation,
          ]);*/
        

        return $this->redirectToRoute('frontend_contact');
    }

}
