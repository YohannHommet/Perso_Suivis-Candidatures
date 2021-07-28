<?php

namespace App\Controller;

use App\Entity\Applications;
use App\Form\ApplicationsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @author YohannHommet yohann.hommet@outlook.fr
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
     * @return Response
     */
    public function index(Applications $application, Request $request): Response
    {
        // check authorizations
        $this->denyAccessUnlessGranted("view", $application);

        $applications = $this->em->getRepository(Applications::class)->findBy(['user' => $this->getUser()], ['date_candidature' => 'DESC']);

        $application = new Applications();
        $form = $this->createForm(ApplicationsFormType::class, $application);
        $form->handleRequest($request);

        // HANDLE FORM
        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('application', $request->request->get('_csrf_token'))) {
            $application->setUser($this->getUser());
            
            $this->em->persist($application);
            $this->em->flush();
            $this->addFlash('success', "Candidature ajoutée chef !");

            return $this->redirectToRoute("app_application");
        }

        // HANDLE ERRORS FOR TURBO
        if ($form->isSubmitted() && !$form->isValid()) {
            $content = $this->renderView('application/index.html.twig', [
                'form' => $form->createView(),
                'applications' => $applications,
            ]);

            return new Response($content, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->render('application/index.html.twig', [
            'form' => $form->createView(),
            'applications' => $applications,
        ]);
    }


    /**
     * @Route("/application/{id}", name="app_application_show", methods={"GET|POST"}, requirements={"id": "\d+"})
     *
     * @param Applications|null $application
     * @param Request $request
     * @return Response
     */
    public function show(Applications $application = null, Request $request): Response
    {
        // Check if $applications exists 
        if (null === $application) {
            throw $this->createNotFoundException("This application does not exist.");
        }

        // check authorizations
        $this->denyAccessUnlessGranted("edit", $application);

        $form = $this->createForm(ApplicationsFormType::class, $application);
        $form->handleRequest($request);

        // HANDLE FORM
        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('application', $request->get('_csrf_token'))) {
            $this->em->flush();
            $this->addFlash('success', "Les données ont été mises à jour.");

            return $this->redirectToRoute("app_application_show", ['id' => $application->getId()]);
        }

        // HANDLE ERRORS FOR TURBO
        if ($form->isSubmitted() && !$form->isValid()) {
            $content = $this->render('application/show.html.twig', [
                'application' => $application,
                'form' => $form->createView()
            ]);

            return new Response($content, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->render('application/show.html.twig', [
            'application' => $application,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/application/{id}/delete", name="app_application_delete", methods={"POST"}, requirements={"id": "\d+"})
     *
     * @param Applications|null $application
     * @param Request $request
     * @return Response
     */
    public function delete(Applications $application = null, Request $request): Response
    {
        if (null === $application) {
            throw $this->createNotFoundException("This application does not exist.");
        }

        // check authorizations
        $this->denyAccessUnlessGranted("delete", $application);

        // HANDLE TOKEN VALIDATION
        if ($this->isCsrfTokenValid('delete'. $application->getId(), $request->request->get('_csrf_token'))) {
            $this->em->remove($application);
            $this->em->flush();
            $this->addFlash("info", "Candidature effacée chef !");
        }

        return $this->redirectToRoute("app_application");
    }
}
