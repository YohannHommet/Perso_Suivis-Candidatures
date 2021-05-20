<?php

namespace App\Controller;

use App\Entity\Applications;
use App\Form\ApplicationsFormType;
use App\Repository\ApplicationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ApplicationController
 * @package App\Controller
 */
class ApplicationController extends AbstractController
{
    /**
     * @Route("/applications", name="app_application", methods={"GET|POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ApplicationsRepository $repository
     *
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $em, ApplicationsRepository $repository): Response
    {
        $application = new Applications();

        $form = $this->createForm(ApplicationsFormType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($application);
            $em->flush();

            return $this->redirectToRoute("app_application");
        }


        return $this->render('application/index.html.twig', [
            'form' => $form->createView(),
            'applications' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/application/{id}", name="app_application_show", methods={"GET|POST"})
     */
    public function show(Applications $applications, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ApplicationsFormType::class, $applications);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($applications);
            $em->flush();

            return $this->redirectToRoute("app_application_show", ['id' => $applications->getId()]);
        }

        return $this->render('application/show.html.twig', [
            'application' => $applications,
            'form' => $form->createView()
        ]);
    }

}
