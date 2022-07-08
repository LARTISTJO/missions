<?php

namespace App\Controller;

use App\Entity\Studies;
use App\Entity\Themes;
use App\Form\StudiesType;
use App\Repository\StudiesRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/studies')]
class StudiesController extends AbstractController
{
    #[Route('/', name: 'app_studies_index', methods: ['GET'])]
    public function index(StudiesRepository $studiesRepository): Response
    {
        return $this->render('studies/index.html.twig', [
            'studies' => $studiesRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'app_studies_new', methods: ['GET', 'POST'])]
    public function new(Request $request,
                        EntityManagerInterface $em,
                        FileUploader $fileUploader): Response
    {
        $study = new Studies();
        $form = $this->createForm(StudiesType::class, $study);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            if ($image) {
                $pictureFilename = $fileUploader->upload($image);
                $study->setImage($pictureFilename);
            }

            $em->persist($study);
            $em->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('studies/new.html.twig', [
            'study' => $study,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/studyby', name: 'show_studies_by', methods: ['GET'])]
    public function showStudies(?Themes $theme ): Response
    {
        if ($theme) {
            $studies = $theme->getStudies()->getValues();
        }else{
            return $this->redirectToRoute('app_home');
        }
        //dd($studies);
        return $this->render('studies/showby.html.twig',[
            'studies' => $studies,
        ]);
    }

    #[Route('/{id}', name: 'app_studies_show', methods: ['GET'])]
    public function show(Studies $study): Response
    {
        return $this->render('studies/show.html.twig', [
            'study' => $study,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_studies_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Studies $study, StudiesRepository $studiesRepository): Response
    {
        $form = $this->createForm(StudiesType::class, $study);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studiesRepository->add($study, true);

            return $this->redirectToRoute('app_studies_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('studies/edit.html.twig', [
            'study' => $study,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_studies_delete', methods: ['POST'])]
    public function delete(Request $request, Studies $study, StudiesRepository $studiesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$study->getId(), $request->request->get('_token'))) {
            $studiesRepository->remove($study, true);
        }

        return $this->redirectToRoute('app_studies_index', [], Response::HTTP_SEE_OTHER);
    }
}
