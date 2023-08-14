<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $grade = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $sufix = null;

    #[ORM\OneToOne(inversedBy: 'course', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Teacher $homeroom_teacher = null;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: Test::class, orphanRemoval: true)]
    private Collection $tests;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrade(): ?int
    {
        return $this->grade;
    }

    public function setGrade(int $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getSufix(): ?string
    {
        return $this->sufix;
    }

    public function setSufix(?string $sufix): static
    {
        $this->sufix = $sufix;

        return $this;
    }

    public function getHomeroomTeacher(): ?Teacher
    {
        return $this->homeroom_teacher;
    }

    public function setHomeroomTeacher(Teacher $homeroom_teacher): static
    {
        $this->homeroom_teacher = $homeroom_teacher;

        return $this;
    }

    /**
     * @return Collection<int, Test>
     */
    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(Test $test): static
    {
        if (!$this->tests->contains($test)) {
            $this->tests->add($test);
            $test->setCourse($this);
        }

        return $this;
    }

    public function removeTest(Test $test): static
    {
        if ($this->tests->removeElement($test)) {
            // set the owning side to null (unless already changed)
            if ($test->getCourse() === $this) {
                $test->setCourse(null);
            }
        }

        return $this;
    }
}
