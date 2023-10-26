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
        $user = $security->getUser();
        $form = $this->createForm(UpdateNameFormType::class, $user);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Mettez à jour le nom de l'utilisateur ici
            $this->entityManager->flush(); // Utilisation de l'entityManager injecté
    
            $this->addFlash('success', 'Le nom a été mis à jour avec succès.');
        }
    
        return $this->render('profile/edit_name.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
