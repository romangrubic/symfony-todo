<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    private $em;
    private $repository;

    public function __construct(ManagerRegistry $doctrine, CategoryRepository $repository)
    {
        $this->em = $doctrine->getManager();
        $this->repository = $repository;
    }

    /**
     * @Route("/category", name="category")
     */
    public function index(): Response
    {
        $categories = $this->repository->findAll();

//        dd($categories[1]);
//        exit;
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
