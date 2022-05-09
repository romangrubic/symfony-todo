<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskFormType;
use App\Repository\TaskRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskController extends AbstractController
{
    private $em;
    private $repository;

    public function __construct(ManagerRegistry $doctrine, TaskRepository $repository)
    {
        $this->em = $doctrine->getManager();
        $this->repository = $repository;
    }

    /**
     * @Route("/task", name="task")
     */
    public function index(UserInterface $user): Response
    {
        $tasks = $this->repository->findBy(['userId'=>$user]);

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/task/create",name = "task_create")
     */
    public function create(Request $request, UserInterface $user): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskFormType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $task->setUserId($user);
            $task->setCreatedAt(new \DateTime('now')) ;

            $this->em->persist($task);
            $this->em->flush();

            $this->addFlash('notice', 'Task created successfully');
            return $this->redirectToRoute('task');
        }
        return $this->renderForm('task/create.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/task/edit/{id}", name="task_edit", methods={"GET", "POST"})
     */
    public function editTask(int $id, Request $request, UserInterface $user): Response
    {
        $task = $this->repository->findOneBy(['id'=>$id, 'userId'=>$user]);
        // Check if task exists with correct User
        if (!$task) {
            return $this->redirectToRoute('task');
        }

        $form = $this->createForm(TaskFormType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//          No need for persist, just save in database
            $this->em->flush();

            $this->addFlash('notice', 'Updated successfully');
            return $this->redirectToRoute('task');
        }
        return $this->renderForm('task/edit.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/task/delete/{id}", name="task_delete")
     */
    public function deleteTask(Task $task): Response
    {
        //Remove and save removal in database
        $this->em->remove($task);
        $this->em->flush();

        $this->addFlash('notice', 'Deleted successfully');
        return $this->redirectToRoute('task');
    }


}
