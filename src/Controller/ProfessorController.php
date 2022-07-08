<?php

namespace App\Controller;

use App\Entity\Professor;
use App\Form\ProfessorType;
use App\Repository\ProfessorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/professor')]
class ProfessorController extends AbstractController
{
    #[Route('/', name: 'app_professor_index', methods: ['GET'])]
    public function index(ProfessorRepository $professorRepository): Response
    {
        return $this->render('professor/index.html.twig', [
            'professors' => $professorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_professor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProfessorRepository $professorRepository): Response
    {
        $professor = new Professor();
        $form = $this->createForm(ProfessorType::class, $professor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $professorRepository->add($professor, true);

            return $this->redirectToRoute('app_professor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('professor/new.html.twig', [
            'professor' => $professor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professor_show', methods: ['GET'])]
    public function show(Professor $professor): Response
    {
        return $this->render('professor/show.html.twig', [
            'professor' => $professor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_professor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Professor $professor, ProfessorRepository $professorRepository): Response
    {
        $form = $this->createForm(ProfessorType::class, $professor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $professorRepository->add($professor, true);

            return $this->redirectToRoute('app_professor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('professor/edit.html.twig', [
            'professor' => $professor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professor_delete', methods: ['POST'])]
    public function delete(Request $request, Professor $professor, ProfessorRepository $professorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professor->getId(), $request->request->get('_token'))) {
            $professorRepository->remove($professor, true);
        }

        return $this->redirectToRoute('app_professor_index', [], Response::HTTP_SEE_OTHER);
    }
}
