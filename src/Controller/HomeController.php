<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AuthorizationCheckerInterface $authChecker): Response
    {
        // Vérifie si l'utilisateur est connecté
        if (!$authChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Redirige l'utilisateur vers une page de connexion
            return $this->redirectToRoute('app_login');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}