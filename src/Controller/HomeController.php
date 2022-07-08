<?php

namespace App\Controller;

use App\Repository\ThemesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $repoThe;

    public function __construct(ThemesRepository $repoThe)
    {
        $this->repoThe = $repoThe;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $themes = $this->repoThe->findAll();
        //dd($themes);

        return $this->render('home/index.html.twig', [
            'themes' => $themes
        ]);
    }
}
