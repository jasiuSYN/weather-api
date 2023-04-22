<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column(length: 255)]
    private string $authToken;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: NotificationDefinition::class, orphanRemoval: true)]
    private Collection $notificationDefinitions;

    public function __construct()
    {
        $this->notificationDefinitions = new ArrayCollection();
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

    public function getAuthToken(): ?string
    {
        return $this->authToken;
    }

    public function setAuthToken(string $authToken): self
    {
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * @return Collection<int, NotificationDefinition>
     */
    public function getNotificationDefinitions(): Collection
    {
        return $this->notificationDefinitions;
    }

    public function addNotificationDefinition(NotificationDefinition $notificationDefinitions): self
    {
        if (!$this->notificationDefinitions->contains($notificationDefinitions)) {
            $this->notificationDefinitions->add($notificationDefinitions);
            $notificationDefinitions->setUserId($this);
        }

        return $this;
    }

    public function removeNotificationDefinition(NotificationDefinition $notificationDefinitions): self
    {
        if ($this->notificationDefinitions->removeElement($notificationDefinitions)) {
            // set the owning side to null (unless already changed)
            if ($notificationDefinitions->getUserId() === $this) {
                $notificationDefinitions->setUserId(null);
            }
        }

        return $this;
    }
}
