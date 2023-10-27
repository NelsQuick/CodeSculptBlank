<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Repository\PostRepository;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface; // Importez l'interface EntityManagerInterface

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AuthorizationCheckerInterface $authChecker, PostRepository $postRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérifie si l'utilisateur est connecté
        if (!$authChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Redirigez l'utilisateur vers une page de connexion
            return $this->redirectToRoute('app_login');
        }
    
        // Créez une instance de l'entité Post
        $post = new Post;
    
        // Créez un formulaire en utilisant le formulaire PostType
        $form = $this->createForm(PostType::class, $post);
    
        // Gérez la soumission du formulaire
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez l'utilisateur actuellement connecté
            $user = $this->getUser();
    
            // Associez l'utilisateur au post
            $post->setUser($user);
    
            // Enregistrez le post en base de données en utilisant l'entityManager
            $entityManager->persist($post);
            $entityManager->flush();
    
            // Redirigez l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }
    
        // Récupère toutes les publications triées par date de création décroissante
        $posts = $postRepository->findBy([], ['date' => 'DESC']);
    
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'posts' => $posts,
            'form' => $form->createView(), // Passez le formulaire à la vue
        ]);
    }
}