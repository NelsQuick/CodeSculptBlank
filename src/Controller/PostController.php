<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostRepository;

class PostController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/post', name: 'app_post')]
    public function create(Request $request): Response
    {
        // Créez une instance de l'entité Post
        $post = new Post();

        // Créez un formulaire en utilisant le formulaire PostType
        $form = $this->createForm(PostType::class, $post);

        // Gérez la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez l'utilisateur actuellement connecté
            $user = $this->getUser();

            // Associez l'utilisateur au post
            $post->setUser($user);

            // Enregistrez le post en base de données en utilisant $this->entityManager
            $this->entityManager->persist($post);
            $this->entityManager->flush();

            // Redirigez l'utilisateur vers une page de confirmation ou de liste des publications
            return $this->redirectToRoute('app_home');
        }

        // Affichez le formulaire de création de post
        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}