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
 * @author Yohann Hommet
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ApplicationController extends AbstractController
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/applications", name="app_application", methods={"GET|POST"})
     *
     * @param Request $request
     * @param ApplicationsRepository $repository
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isVerified() && !$user) {
            throw $this->createAccessDeniedException("Your account is not verified. Please verify your account before continuing.");
        }

        $application = new Applications();
        $form = $this->createForm(ApplicationsFormType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($application);
            $this->em->flush();
            
            $this->addFlash('success', "Candidature ajoutée chef !");
            
            return $this->redirectToRoute("app_application");
        }

        return $this->render('application/index.html.twig', [
            'form' => $form->createView(),
            'applications' => $this->em->getRepository(Applications::class)->findAll(),
        ]);
    }


    /**
     * @Route("/application/{id}", name="app_application_show", methods={"GET|POST"}, requirements={"id": "\d+"})
     *
     * @param Applications $applications
     * @param Request $request
     * 
     * @return Response
     */
    public function show(Applications $application = null, Request $request): Response
    {
        // Check if $applications exists 
        if (null === $application) {
            throw $this->createNotFoundException("This application does not exist.");
        }

        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isVerified() && !$user) {
            throw $this->createAccessDeniedException("Your account is not verified. Please verify your account before continuing.");
        }

        $form = $this->createForm(ApplicationsFormType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', "Les données ont été mises à jour.");

            return $this->redirectToRoute("app_application_show", ['id' => $application->getId()]);
        }

        return $this->render('application/show.html.twig', [
            'application' => $application,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/application/{id}/delete", name="app_application_delete", methods={"GET|POST"}, requirements={"id": "\d+"})
     * 
     * @param Applications $applications
     * 
     * @return Response
     */
    public function delete(Applications $application = null): Response
    {
        if (null === $application) {
            throw $this->createNotFoundException("This application does not exist.");
        }

        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isVerified() && !$user) {
            throw $this->createAccessDeniedException("Your account is not verified. Please verify your account before continuing.");
        }
        
        $this->em->remove($application);
        $this->em->flush();
        $this->addFlash("info", "Cette candidature a bien été effacée");

        return $this->redirectToRoute("app_application");
    }

}
