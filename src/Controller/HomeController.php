<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Repository\MangaRepository;
use App\service\MangasManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MangaRepository $mangaRepo, MangasManager $mangasManager): Response
    {
        $mangas = $mangasManager->getRandomMangas();
        $mangasRating = $mangaRepo->findMangaByRating();
        $shounenMangas = $mangasManager->getRandomShounenMangas();
        return $this->render('home/index.html.twig', [
            'mangas' => $mangas,
            'mangasRating' => $mangasRating,
            'shounenMangas' => $shounenMangas,
        ]);
    }

    #[Route('/show/{id}', name: 'app_show')]
    public function Show(Manga $manga): Response
    {
        
        return $this->render('home/show.html.twig', [
            'manga' => $manga,
        ]);
    }
}
