<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Repository\PostRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AuthorizationCheckerInterface $authChecker, PostRepository $postRepository): Response
    {
        // Vérifie si l'utilisateur est connecté
        if (!$authChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Redirige l'utilisateur vers une page de connexion
            return $this->redirectToRoute('app_login');
        }

        // Récupère toutes les publications
        $posts = $postRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'posts' => $posts,
        ]);
    }
}
