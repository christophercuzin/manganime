<?php

namespace App\Entity;

use App\Repository\UserMangaListRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserMangaListRepository::class)]
class UserMangaList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column]
    private int $numberOfVolume;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $listOfVolume = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status;

    #[ORM\ManyToOne(inversedBy: 'userMangaLists')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(inversedBy: 'userMangaLists')]
    private ?Manga $manga;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getNumberOfVolume(): int
    {
        return $this->numberOfVolume;
    }

    public function setNumberOfVolume(int $numberOfVolume): self
    {
        $this->numberOfVolume = $numberOfVolume;

        return $this;
    }

    public function getListOfVolume(): ?array
    {
        return $this->listOfVolume;
    }

    public function setListOfVolume(?array $listOfVolume): self
    {
        $this->listOfVolume = $listOfVolume;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getManga(): ?Manga
    {
        return $this->manga;
    }

    public function setManga(?Manga $manga): self
    {
        $this->manga = $manga;

        return $this;
    }
}
