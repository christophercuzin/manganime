<?php

namespace App\service;

use App\Entity\Manga;
use App\Repository\MangaRepository;
use Doctrine\ORM\EntityManagerInterface;

class MangaUtils
{
    private array $allMangaDetails = [];
    private EntityManagerInterface $entityManager;
    private array $checkErrors = [];
    private MangaRepository $mangaRepo;
    private array $mangaTitle = [];

    public function __construct(
        EntityManagerInterface $entityManager,
        MangaRepository $mangaRepo,
    ) {
        $this->entityManager = $entityManager;
        $this->mangaRepo = $mangaRepo;
    }

    public function retrieveManga(array $data): array
    {
        $numberOfManga = $data['numberOfManga'];
        for ($i=0; $i < $numberOfManga; $i++) { 
            $mangaDetails = [];
            $mangaDetails [] = $data['mangaTitle' . $i];
            $mangaDetails [] = $data['mangaNumberOfVolumes' . $i];
            $mangaDetails [] = $data['mangaDescription' . $i];
            $mangaDetails [] = $data['mangaStatus' . $i];
            $mangaDetails [] = $data['mangaAuthor' . $i];
            $mangaDetails [] = $data['mangaGenre' . $i];
            $this->allMangaDetails[] = $mangaDetails;
        }
        return $this->allMangaDetails;
    }

    public function retrieveMangaTitle(): array
    {
        $mangas = $this->mangaRepo->findAll();
        foreach ($mangas as $manga) {
            $this->mangaTitle[] = $manga->getTitle();
        }
        return $this->mangaTitle;
    }

    public function addManga($data): void
    {
        $allManga = $this->retrieveManga($data);
        $mangasTitle = $this->retrieveMangaTitle();
        if (empty($this->checkErrors)) {
            $em = $this->entityManager;

            foreach ($allManga as $mangaDetail) {
                if (!in_array($mangaDetail[0], $mangasTitle)) {
                    $manga = new Manga;
                    $manga->setTitle($mangaDetail[0]);
                    if ($mangaDetail[1] === "") {
                        $manga->setNumberOfVolumes(null);
                    } else {
                    $manga->setNumberOfVolumes($mangaDetail[1]);
                    }
                    $manga->setDescription($mangaDetail[2]);
                    $manga->setStatus($mangaDetail[3]);
                    $manga->setAuthor($mangaDetail[4]);
                    $manga->setGenre($mangaDetail[5]);
                    $em->persist($manga);
                }
            }
            $em->flush();
        }


    }
}
