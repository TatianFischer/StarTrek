<?php

namespace App\Controller\Admin;

use App\Entity\Episode;
use App\Entity\Film;
use App\Entity\Personnage;
use App\Entity\Saison;
use App\Entity\Serie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Star Trek');
    }

    public function configureCrud(): Crud
    {
        return Crud::new();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Serie', 'fas fa-folder-open', Serie::class);
        yield MenuItem::linkToCrud('Film', 'fas fa-folder-open', Film::class);
        yield MenuItem::linkToCrud('Personnage', 'fas fa-folder-open', Personnage::class);
        yield MenuItem::linkToCrud('Saison', 'fas fa-folder-open', Saison::class);
        yield MenuItem::linkToCrud('Episode', 'fas fa-folder-open', Episode::class);
    }

    /**
     * @Route("/admin", name="easyadmin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(SerieCrudController::class)->generateUrl());

        // you can also redirect to different pages depending on the current user
        /*if ('jane' === $this->getUser()->getUsername()) {
            return $this->redirect('...');
        }*/

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/admin.css');
    }
}
