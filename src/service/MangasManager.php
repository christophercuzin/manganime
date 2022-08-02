<?php

namespace App\service;

use App\Entity\Manga;
use App\Repository\MangaRepository;

class MangasManager
{
    private MangaRepository $mangaRepo;
    

    public function __construct(
        MangaRepository $mangaRepo,
    ) {
        $this->mangaRepo = $mangaRepo;
    }

    public function getRandomMangas(): array
    {
        $mangas = [];
        $allMangas = $this->mangaRepo->findAll();
        $randomKeys = array_rand($allMangas, 20);

        foreach ($randomKeys as $key) {
            $mangas[] = $allMangas[$key];
        }
        
        return $mangas;
    }

    public function getRandomShounenMangas(): array
    {
        $Shounenmangas = [];
        $allShounen = $this->mangaRepo->findShounenMangas();
        $randomKeys = array_rand($allShounen, 20);

        foreach ($randomKeys as $key) {
            $Shounenmangas[] = $allShounen[$key];
        }
        
        return $Shounenmangas;
    }
}