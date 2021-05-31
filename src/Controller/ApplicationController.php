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
    public function index(Request $request, ApplicationsRepository $repository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isVerified()) {
            $this->addFlash('danger', "Vous devez vérifier votre compte pour accéder à cette page.");
            return $this->redirectToRoute("app_home");
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
            'applications' => $repository->findAll()
        ]);
    }


    /**
     * @Route("/application/{id}", name="app_application_show", methods={"GET|POST"})
     *
     * @param Applications $applications
     * @param Request $request
     * 
     * @return Response
     */
    public function show(Applications $applications, Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isVerified()) {
            $this->addFlash('danger', "Vous devez vérifier votre compte pour accéder à cette page.");
            return $this->redirectToRoute("app_home");
        }

        $form = $this->createForm(ApplicationsFormType::class, $applications);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($applications);
            $this->em->flush();

            $this->addFlash('success', "Les données ont été mises à jour.");
            return $this->redirectToRoute("app_application_show", ['id' => $applications->getId()]);
        }

        return $this->render('application/show.html.twig', [
            'application' => $applications,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/application/{id}/delete", name="app_application_delete", methods={"GET|POST"})
     * 
     * @param Applications $applications
     * 
     * @return Response
     */
    public function delete(Applications $applications): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isVerified()) {
            $this->addFlash('danger', "Vous devez vérifier votre compte pour accéder à cette page.");
            return $this->redirectToRoute("app_home");
        }
        
        $this->em->remove($applications);
        $this->em->flush();
        
        $this->addFlash("info", "Cette candidature a bien été effacée");
        return $this->redirectToRoute("app_application");
    }
    
    

}
