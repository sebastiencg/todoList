<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\ProfileType;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
    }

    #[Route('/profile/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProfileRepository $profileRepository): Response
    {

        $profile=$this->getUser()->getProfile();
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profileRepository->save($profile, true);

            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('profile/edit.html.twig', [
            'todo' => $profile,
            'form' => $form,
        ]);
    }
    #[Route('/addInvite/{id}', name: 'app_add_invite')]
    public function addInvite(Todo $todo,ProfileRepository $profileRepository ): Response
    {
        return $this->render('profile/invite.html.twig',[
            'profiles'=>$profileRepository->findAll(),
            'todo'=>$todo
        ]);
    }

}
