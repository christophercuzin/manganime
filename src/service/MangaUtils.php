<?php

namespace App\service;

use App\Entity\Genre;
use App\Entity\Manga;
use App\Repository\MangaRepository;
use App\Repository\UserMangaListRepository;
use Doctrine\ORM\EntityManagerInterface;

class MangaUtils
{
    private array $allMangaDetails = [];
    private EntityManagerInterface $entityManager;
    private array $checkErrors = [];
    private MangaRepository $mangaRepo;
    private array $mangaTitle = [];
    private UserMangaListRepository $userMangaRepo;

    public function __construct(
        EntityManagerInterface $entityManager,
        MangaRepository $mangaRepo,
        UserMangaListRepository $userMangaRepo,

    ) {
        $this->entityManager = $entityManager;
        $this->mangaRepo = $mangaRepo;
        $this->userMangaRepo = $userMangaRepo;
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
            $mangaDetails [] = explode(',', $data['mangaGenre' . $i]);
            $mangaDetails [] = $data['mangaImage' . $i];
            $mangaDetails [] = $data['mangaType' . $i];
            $mangaDetails [] = $data['mangaRate' . $i];
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

    public function addManga(array $data): void
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
                    $manga->setType($mangaDetail[7]);
                    $manga->setRate($mangaDetail[8]);
                    $this->addMangaImage($manga, $mangaDetail);
                    $em->persist($manga);
                    $this->updateMangaId($manga, $mangaDetail);
                    $this->addGenre($manga, $mangaDetail);
                
                }
                $em->flush();
            }
            
        }
    }

    public function updateMangaId(Manga $manga, array $mangaDetail): void {
        $em = $this->entityManager;
        $userMangalists = $this->userMangaRepo->findAll();
        foreach ($userMangalists as $userManga) {
            if ($mangaDetail[0] === $userManga->getTitle()) {
                $userManga->setManga($manga);
            }
            $em->persist($userManga);
        }
    }

    public function addGenre(Manga $manga, array $mangaDetail): void
    {
        $em = $this->entityManager;
        foreach ($mangaDetail[5] as $mangaGenre) {
            $genre = new Genre;
            $genre->setGenre($mangaGenre);
            $genre->setManga($manga);
            $em->persist($genre);

        }
    }

    public function addMangaImage(Manga $manga, array $mangaDetail): void
    {
        $url = $mangaDetail[6];
        $img = '../assets/images/' . uniqid('manga', true) . '.webp';
        file_put_contents($img, file_get_contents($url));
        $manga->setPicture(preg_replace('/(^\.)\.\/assets/', 'build', $img));
    }
}
