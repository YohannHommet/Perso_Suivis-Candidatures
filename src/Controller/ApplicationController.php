<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Applications;
use App\Form\ApplicationsFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ApplicationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;


/**
 * @author Yohann Hommet
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ApplicationController extends AbstractController
{

    private EntityManagerInterface $em;
    private CsrfTokenManagerInterface $csrfTokenManager;

    public function __construct(EntityManagerInterface $em, CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->em = $em;
        $this->csrfTokenManager = $csrfTokenManager;
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
        // Check if the user can access
        $this->isLogged($user);
        $this->isVerified($user);

        $applications = $this->em->getRepository(Applications::class)->findBy(['user' => $user], ['date_candidature' => 'DESC']);

        $application = new Applications();

        $form = $this->createForm(ApplicationsFormType::class, $application);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion Token
            $token = new CsrfToken('application', $request->get('_csrf_token'));
            if (!$this->csrfTokenManager->isTokenValid($token)) {
                throw new InvalidCsrfTokenException();
            }

            $application->setUser($user);
            $this->em->persist($application);
            $this->em->flush();
            
            $this->addFlash('success', "Candidature ajoutée chef !");
            
            return $this->redirectToRoute("app_application");
        }

        return $this->render('application/index.html.twig', [
            'form' => $form->createView(),
            'applications' => $applications,
        ]);
    }


    /**
     * @Route("/application/{id}", name="app_application_show", methods={"GET|POST"}, requirements={"id": "\d+"})
     * 
     * @paramConverter("application", class=Applications::class, options={"id" = "id"})
     * @param Applications $application
     * @param Request $request
     * 
     * @return Response
     */
    public function show(Applications $application = null, Request $request, MailerInterface $mailer): Response
    {
        // Check if $applications exists 
        if (null === $application) {
            throw $this->createNotFoundException("This application does not exist.");
        }

        /** @var User $user */
        $user = $this->getUser();
        // Check if the user can access
        $this->isLogged($user);
        $this->isVerified($user);
        $this->isAllowedToAccessApplication($user, $application);

        $form = $this->createForm(ApplicationsFormType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion Token
            $token = new CsrfToken('application', $request->get('_csrf_token'));
            if (!$this->csrfTokenManager->isTokenValid($token)) {
                throw new InvalidCsrfTokenException();
            }

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
     * @paramConverter("application", class=Applications::class, options={"id" = "id"})
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
        $this->isLogged($user);
        $this->isVerified($user);
        $this->isAllowedToAccessApplication($user, $application);
        
        $this->em->remove($application);
        $this->em->flush();
        $this->addFlash("info", "Candidature effacée chef !");

        return $this->redirectToRoute("app_application");
    }


    /**
     * Check if User is logged in
     */
    private function isLogged($user)
    {
        if (!$user) {
            throw $this->createAccessDeniedException("You have to be logged in to access this page");
        }
    }
    /**
     * Check if User is verified
     */
    private function isVerified($user)
    {
        if (!$user->isVerified()) {
            throw $this->createAccessDeniedException("You have to verify your email address to access this page");
        }
    }
    /**
     * Check if User is allowed to access the requested application
     */
    private function isAllowedToAccessApplication(User $user, Applications $application)
    {
        if ($application->getUser() !== $user) {
            throw $this->createAccessDeniedException("You are not allowed to access this application.");
        }
    }
}
