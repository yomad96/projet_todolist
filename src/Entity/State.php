<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\StateRepository")
 */
class State
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\task", mappedBy="state")
     */
    private $task;

    public function __construct()
    {
        $this->task = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|task[]
     */
    public function getTask(): Collection
    {
        return $this->task;
    }

    public function addTask(task $task): self
    {
        if (!$this->task->contains($task)) {
            $this->task[] = $task;
            $task->setState($this);
        }

        return $this;
    }

    public function removeTask(task $task): self
    {
        if ($this->task->contains($task)) {
            $this->task->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getState() === $this) {
                $task->setState(null);
            }
        }

        return $this;
    }
}
