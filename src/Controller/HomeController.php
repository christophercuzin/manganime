<?php

namespace App\Controller;

use App\Repository\MangaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MangaRepository $mangaRepo): Response
    {
        $mangas = $mangaRepo->findAll();
        return $this->render('home/index.html.twig', [
            'mangas' => $mangas,
        ]);
    }
}
