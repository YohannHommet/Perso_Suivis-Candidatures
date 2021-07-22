<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/about", name="app_home_about", methods={"GET"})
     * @return Response
     */
    public function disclaimer(): Response
    {
        return $this->render('home/disclaimer.html.twig', []);
    }
}
