<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $short_name = null;

    #[ORM\OneToMany(mappedBy: 'subject', targetEntity: CourseSubject::class)]
    private Collection $courseSubjects;


    public function __construct()
    {
        $this->courseSubjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->short_name;
    }

    public function setShortName(?string $short_name): static
    {
        $this->short_name = $short_name;

        return $this;
    }
    
    /**
     * @return Collection<int, CourseSubject>
     */
    public function getCourseSubjects(): Collection
    {
        return $this->courseSubjects;
    }

    public function addCourseSubject(CourseSubject $courseSubject): static
    {
        if (!$this->courseSubjects->contains($courseSubject)) {
            $this->courseSubjects->add($courseSubject);
            $courseSubject->setSubject($this);
        }

        return $this;
    }

    public function removeCourseSubject(CourseSubject $courseSubject): static
    {
        if ($this->courseSubjects->removeElement($courseSubject)) {
            // set the owning side to null (unless already changed)
            if ($courseSubject->getSubject() === $this) {
                $courseSubject->setSubject(null);
            }
        }

        return $this;
    }
}
