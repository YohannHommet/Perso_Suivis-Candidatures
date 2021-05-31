<?php

namespace App\Controller;

use App\Entity\Applications;
use App\Entity\User;
use App\Form\ApplicationsFormType;
use App\Repository\ApplicationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ApplicationController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
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
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isVerified()) {
//            throw $this->createAccessDeniedException("Vous devez vérifier votre compte pour accéder à cette page.");
            $this->addFlash('danger', "Vous devez vérifier votre compte pour accéder à cette page.");
            return $this->redirectToRoute("app_home");
        }

        $application = new Applications();
        $form = $this->createForm(ApplicationsFormType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($application);
            $em->flush();

            $this->addFlash('success', "Candidature ajoutée chef !");
            return $this->redirectToRoute("app_application");
        }


        return $this->render('application/index.html.twig', [
            'form' => $form->createView(),
            'applications' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/application/{id}", name="app_application_show", methods={"GET|POST"})
     *
     * @param Applications $applications
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function show(Applications $applications, Request $request, EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isVerified()) {
//            throw $this->createAccessDeniedException("Vous devez vérifier votre compte pour accéder à cette page.");
            $this->addFlash('danger', "Vous devez vérifier votre compte pour accéder à cette page.");
            return $this->redirectToRoute("app_home");
        }

        $form = $this->createForm(ApplicationsFormType::class, $applications);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($applications);
            $em->flush();

            $this->addFlash('success', "Les données ont été mises à jour.");
            return $this->redirectToRoute("app_application_show", ['id' => $applications->getId()]);
        }

        return $this->render('application/show.html.twig', [
            'application' => $applications,
            'form' => $form->createView()
        ]);
    }

}
