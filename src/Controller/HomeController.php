<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @author YohannHommet <yohann.hommet@outlook.fr>
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
