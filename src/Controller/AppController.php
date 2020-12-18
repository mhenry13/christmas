<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AppController extends AbstractController
{

    /**
     * @Route("/tableau-de-bord", methods="GET", name="homepage")
     */
    public function index(Request $request,Security $security): Response
    {

        if ($security->isGranted('ROLE_USER') || $security->isGranted('ROLE_ADMIN') ) {

        } else {

            return $this->redirectToRoute('security_login');
        }
        return $this->render('App/dashboard.html.twig');
    }



}