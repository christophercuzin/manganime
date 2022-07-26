<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private int $id;

    #[ORM\Column(length: 180, unique: true)]
    private string $email;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserMangaList::class, orphanRemoval: true)]
    private Collection $userMangaLists;

    public function __construct()
    {
        $this->usersMangaLists = new ArrayCollection();
        $this->userMangaLists = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, UsersMangaList>
     */
    public function getUsersMangaLists(): Collection
    {
        return $this->usersMangaLists;
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
            $userMangaList->setUser($this);
        }

        return $this;
    }

    public function removeUserMangaList(UserMangaList $userMangaList): self
    {
        $this->userMangaLists->removeElement($userMangaList);

        return $this;
    }
    
    public function getMissingVolumes(): array {
        $missingVolumes = [];
        $userMangaLists = $this->getUserMangaLists();
        foreach ($userMangaLists as $userMangaList) {
            $listOfVolume = $userMangaList->getListOfVolume();
            if ($userMangaList->getManga() != null) {
                $manga = $userMangaList->getManga(); 
                $numberOfVolume = $manga->getNumberOfVolumes();
                $key = $userMangaList->getTitle();
                for ($i=1; $i <= $numberOfVolume; $i++) { 
                    if (!in_array($i, $listOfVolume)) {
                        $missingVolumes[$key][] = $i;
                    }
                }
            }
        }
        return $missingVolumes;
    }

}
