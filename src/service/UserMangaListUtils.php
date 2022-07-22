<?php

namespace App\service;

use App\Entity\User;
use App\Entity\UserMangaList;
use App\Repository\MangaRepository;
use App\Repository\UserMangaListRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserMangaListUtils
{
    private array $listOfVolume = [];
    private EntityManagerInterface $entityManager;
    private array $checkErrors = [];
    private UserMangaListRepository $userMangaRepo;
    private array $mangaTitle = [];
    private MangaRepository $mangaRepo;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserMangaListRepository $userMangaRepo,
        MangaRepository $mangaRepo,
    ) {
        $this->entityManager = $entityManager;
        $this->userMangaRepo = $userMangaRepo;
        $this->mangaRepo = $mangaRepo;
    }

    public function retrieveListOfVolume(array $data): array
    {
        $numberOfVolumeListed = $data['number_of_volume_input'];
        for ($i=0; $i < $numberOfVolumeListed; $i++) { 
            if (!empty($data['volume' . $i])){
            $this->listOfVolume[] = $data['volume' . $i];
            }
        }
        return $this->listOfVolume;
    }

    public function retrieveMangaTitle(User $user): array
    {
        $mangas = $this->userMangaRepo->findBy(['user' => $user]);
        foreach ($mangas as $manga) {
            $this->mangaTitle[] = $manga->getTitle();
        }
        return $this->mangaTitle;
    }

    public function addUserMangaList(array $data, User $user): void
    {
        $manga = $this->mangaRepo->findOneBy(['title' => $data['manga_title']]);
        $listOfVolume = $this->retrieveListOfVolume($data);
        $mangasTitle = $this->retrieveMangaTitle($user);
        $userManga = new UserMangaList;
        if (empty($this->checkErrors)) {
            $em = $this->entityManager;
            if (!in_array($data['manga_title'], $mangasTitle)) {

                $userManga->setTitle($data['manga_title']);
                $userManga->setNumberOfVolume($data['number_of_volume']);
                $userManga->setStatus($data['status']);
                $userManga->setListOfVolume($listOfVolume);
                $userManga->setUser($user);
                $userManga->setManga($manga);
                $em->persist($userManga);
            }
            $em->flush();
        }



    }
}