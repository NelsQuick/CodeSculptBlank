<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/search/users', name: 'search_users', methods: "GET")]
    public function searchUsers(Request $request)
    {
        $searchTerm = $request->query->get('q'); // Récupérer le terme de recherche depuis la requête GET

        // Effectuer la recherche dans la base de données
        $userRepository = $this->entityManager->getRepository(User::class); // Supposons que vous ayez une entité User

        // Créez une requête personnalisée pour rechercher des utilisateurs dont le nom d'utilisateur commence par la chaîne de recherche
        $queryBuilder = $userRepository->createQueryBuilder('u');
        $queryBuilder->where($queryBuilder->expr()->like('u.username', $queryBuilder->expr()->literal($searchTerm . '%')));

        $users = $queryBuilder->getQuery()->getResult();

        // Retourner les résultats dans une réponse JSON
        $usernames = [];
        foreach ($users as $user) {
            $usernames[] = $user->getUsername();
        }

        return new JsonResponse($usernames);
    }
}
