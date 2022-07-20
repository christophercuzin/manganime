<?php

namespace App\Entity;

use App\Repository\UsersMangaListRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersMangaListRepository::class)]
class UsersMangaList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column]
    private int $numberOfVolumes;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $listOfVolumes = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status;

    #[ORM\ManyToOne(inversedBy: 'usersMangaLists')]
    private ?User $user;

    #[ORM\ManyToOne]
    private Manga $manga;

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

    public function getNumberOfVolumes(): int
    {
        return $this->numberOfVolumes;
    }

    public function setNumberOfVolumes(int $numberOfVolumes): self
    {
        $this->numberOfVolumes = $numberOfVolumes;

        return $this;
    }

    public function getListOfVolumes(): array
    {
        return $this->listOfVolumes;
    }

    public function setListOfVolumes(?array $listOfVolumes): self
    {
        $this->listOfVolumes = $listOfVolumes;

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

    public function getManga(): Manga
    {
        return $this->manga;
    }

    public function setManga(Manga $manga): self
    {
        $this->manga = $manga;

        return $this;
    }
}
