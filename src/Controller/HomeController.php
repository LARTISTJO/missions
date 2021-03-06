<?php

namespace App\Controller;

use App\Entity\Studies;
use App\Entity\Themes;
use App\Repository\StudiesRepository;
use App\Repository\ThemesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $repoThe;
    private $repoStu;

    public function __construct(ThemesRepository $repoThe, StudiesRepository $repoStu)
    {
        $this->repoThe = $repoThe;
        $this->repoStu = $repoStu;
    }

    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        $themes = $this->repoThe->findAll();

        $studies = $this->repoStu->findAll();

        return $this->render('home/index.html.twig', [
            'themes' => $themes ,
            'studies' => $studies,
        ]);
    }

}
