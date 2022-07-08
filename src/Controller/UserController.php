<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name:'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/edit/{id<\d+>}', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,
                         User $user,
                         EntityManagerInterface $em,
                         UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // ParamConverter
        if (null === $user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $userform = $this->createForm(UserType::class, $user);
        $userform->handleRequest($request);

        if ($userform->isSubmitted() && $userform->isValid()) {
            if (!empty($userform->get('password')->getData())) {
                $hashedPassword = $userPasswordHasher->hashPassword($user, $userform->get('password')->getData());
                $user->setPassword($hashedPassword);
            }

            $em->flush();

            $this->addFlash('success', 'Votre profil a bien été mis à jour.');

            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        if ($this->getUser()->getUserIdentifier() === $user->getUserIdentifier()) {
            return $this->render('user/edit.html.twig', [
                'user' => $user,
                'userform' => $userform->createView()
            ]);
        } else {
            $this->addFlash('warning', 'Vous ne pouvez pas modifier le profil d\'un autre utilisateur.');
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(User $user,
                           EntityManagerInterface $em ): Response
    {
        $this->container->get('security.token_storage')->setToken(null);

        $em->remove($user);
        $em->flush();

// Ceci ne fonctionne pas avec la création d'une nouvelle session !
        $this->addFlash('success', 'Votre compte utilisateur a bien été supprimé !');
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
