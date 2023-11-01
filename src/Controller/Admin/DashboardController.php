<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Créez un générateur d'URL pour EasyAdmin
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);

        // Générez l'URL pour le contrôleur UserCrudController
        $url = $routeBuilder->setController(UserCrudController::class)->generateUrl();

        // Redirigez vers l'URL générée
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        // Configure le tableau de bord EasyAdmin
        return Dashboard::new()
            ->setTitle('CodeSculptBlank'); // Définissez le titre du tableau de bord
    }

    public function configureMenuItems(): iterable
    {
        // Configurez les éléments du menu
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class); // Ajoute un lien vers le CRUD pour l'entité User
        yield MenuItem::linkToCrud('Post', 'fas fa-list', Post::class); // Ajoute un lien vers le CRUD pour l'entité Post
        yield MenuItem::linkToRoute('CodeSculpt.fr', 'fa fa-home', 'app_home'); // Ajoute un lien personnalisé vers une route nommée 'app_home'
    }
}
