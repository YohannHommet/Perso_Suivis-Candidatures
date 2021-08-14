<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @author YohannHommet <yohann.hommet@outlook.fr>
 * 
 * @package App\Controller
 * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', []);
    }

    /**
     * @Route("/disclaimer", name="app_disclaimer", methods={"GET"})
     * @return Response
     */
    public function disclaimer(): Response
    {
        return $this->render('home/disclaimer.html.twig', []);
    }

    /**
     * @Route("/theme_switch", name="app_theme_switch", methods={"GET"})
     * @return Response
     */
    public function themeSwitch(SessionInterface $session): Response
    {
        // get session and set theme to red or blue
        if ($session->get('theme') === null) {
            $session->set('theme', 'red');
        } else {
            $session->remove('theme');
        }

        return $this->redirectToRoute('app_home');
    }
}
