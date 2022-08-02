<?php

namespace App\Entity;

use App\Repository\MangaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MangaRepository::class)]
class Manga
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(length: 255)]
    private string $author;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfVolumes;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\Column(length: 255)]
    private string $status;

    #[ORM\Column(length: 255, nullable: true)]
    private string $picture;

    #[ORM\OneToMany(mappedBy: 'manga', targetEntity: UserMangaList::class)]
    private Collection $userMangaLists;

    #[ORM\OneToMany(mappedBy: 'manga', targetEntity: Genre::class)]
    private Collection $genres;

    #[ORM\Column(nullable: true)]
    private ?float $rate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    public function __construct()
    {
        $this->userMangaLists = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }

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

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getNumberOfVolumes(): ?int
    {
        return $this->numberOfVolumes;
    }

    public function setNumberOfVolumes(?int $numberOfVolumes): self
    {
        $this->numberOfVolumes = $numberOfVolumes;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, UserMangaList>
     */
    public function getUserMangaLists(): Collection
    {
        return $this->userMangaLists;
    }

    public function addUserMangaList(UserMangaList $userMangaList): self
    {
        if (!$this->userMangaLists->contains($userMangaList)) {
            $this->userMangaLists[] = $userMangaList;
            $userMangaList->setManga($this);
        }

        return $this;
    }

    public function removeUserMangaList(UserMangaList $userMangaList): self
    {
        if ($this->userMangaLists->removeElement($userMangaList)) {
            // set the owning side to null (unless already changed)
            if ($userMangaList->getManga() === $this) {
                $userMangaList->setManga(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
            $genre->setManga($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genres->removeElement($genre)) {
            // set the owning side to null (unless already changed)
            if ($genre->getManga() === $this) {
                $genre->setManga(null);
            }
        }

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(?float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
