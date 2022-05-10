<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavbarController extends AbstractController
{
    protected $categories;

    /**
     * @Route("/navbar", name="app_navbar")
     */
    public function __construct(CategoryRepository $repo)
    {
//        parent::__construct();
        $this->categories = $repo->findAll();

    }
}
