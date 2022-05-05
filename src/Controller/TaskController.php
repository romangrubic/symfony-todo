<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    private $doctrine;
    private $repository;

    public function __construct(ManagerRegistry $doctrine, TaskRepository $repository)
    {
        $this->doctrine = $doctrine;
        $this->repository = $repository;
    }

    /**
     * @Route("/task", name="app_task")
     */
    public function index(): Response
    {
        $tasks = $this->repository->findAll();

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }
}
