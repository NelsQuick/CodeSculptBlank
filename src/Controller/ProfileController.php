<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Form\UpdateNameFormType;
use Doctrine\ORM\EntityManagerInterface; // Import de l'EntityManagerInterface

class ProfileController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, Security $security): Response
    {
        $user = $security->getUser();
    
        $nameForm = $this->createForm(UpdateNameFormType::class, $user);
    
        $nameForm->handleRequest($request);
    
        if ($nameForm->isSubmitted() && $nameForm->isValid()) {
            $this->entityManager->flush(); // Utilisation de l'entityManager injecté
            
            $this->addFlash('success', 'Le nom a été mis à jour avec succès.');
        }
    
        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'nameForm' => $nameForm->createView(),
        ]);
    }

    #[Route('/profile/edit-name', name: 'app_profile_edit_name')]
    public function editName(Request $request, Security $security): Response
    {
        // Obtenez l'utilisateur connecté
        $user = $security->getUser();
    
        // Créez un formulaire de type UpdateNameFormType lié à l'objet utilisateur
        $form = $this->createForm(UpdateNameFormType::class, $user);
    
        // Gérez la soumission du formulaire
        $form->handleRequest($request);
    
        // Vérifiez si le formulaire a été soumis et s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
    
            // Utilisation de l'EntityManager injecté pour enregistrer les changements en base de données
            $this->entityManager->flush();
    
        }
    
        // Renvoyez la vue de la page d'édition du nom avec l'utilisateur et le formulaire
        return $this->render('profile/edit_name.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}