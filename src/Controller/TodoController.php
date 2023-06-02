<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo_index', methods: ['GET'])]
    public function index(TodoRepository $todoRepository): Response
    {
        return $this->render('todo/index.html.twig', [
            'todos' => $todoRepository->findBy(['statu'=>false]),
        ]);
    }
    #[Route('/alreadyDone/', name: 'app_todo_alreadyDone', methods: ['GET'])]
    public function alreadyDone(TodoRepository $todoRepository): Response
    {
        return $this->render('todo/alreadyDone.html.twig', [
            'todos' => $todoRepository->findBy(['statu'=>true, 'author'=>$this->getUser()]),
        ]);
    }


    #[Route('/new', name: 'app_todo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TodoRepository $todoRepository): Response
    {
        $todo = new Todo();
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todo->setCreatedAt(new \DateTime());
            $todo->setStatu(false);
            $todo->setAuthor($this->getUser()->getProfile());
            $todoRepository->save($todo, true);

            return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('todo/new.html.twig', [
            'todo' => $todo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_todo_show', methods: ['GET'])]
    public function show(Todo $todo): Response
    {
        return $this->render('todo/show.html.twig', [
            'todo' => $todo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_todo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Todo $todo, TodoRepository $todoRepository): Response
    {
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoRepository->save($todo, true);

            return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('todo/edit.html.twig', [
            'todo' => $todo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_todo_delete', methods: ['POST'])]
    public function delete(Request $request, Todo $todo, TodoRepository $todoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$todo->getId(), $request->request->get('_token'))) {
            $todoRepository->remove($todo, true);
        }

        return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/finish/{id}', name: 'app_todo_finish', methods: ['POST','GET'])]
    public function finish(Todo $todo, TodoRepository $todoRepository): Response
    {
        if(!$todo->isStatu()){
            $todo->setStatu(true);
            $todoRepository->save($todo, true);
        }
        return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/profile/{profile}', name: 'app_todo_addInvite', methods: ['POST','GET'])]
    public function addInvite(Todo $todo,Profile $profile, TodoRepository $todoRepository): Response
    {

        $todo->addInvite($profile);
        $todoRepository->save($todo, true);
        return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
    }

}
