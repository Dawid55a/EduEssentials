<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherRepository::class)]
class Teacher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: 'teacher', cascade: ['persist', 'remove'])]
    private ?User $auth_user = null;

    #[ORM\OneToOne(mappedBy: 'home_teacher', cascade: ['persist', 'remove'])]
    private ?Course $course = null;

    #[ORM\ManyToMany(targetEntity: Subject::class, inversedBy: 'teachers')]
    private Collection $subjects;

    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: Test::class, orphanRemoval: true)]
    private Collection $tests;

    public function __construct()
    {
        $this->subjects = new ArrayCollection();
        $this->tests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthUser(): ?User
    {
        return $this->auth_user;
    }

    public function setAuthUser(?User $auth_user): static
    {
        // unset the owning side of the relation if necessary
        if ($auth_user === null && $this->auth_user !== null) {
            $this->auth_user->setTeacher(null);
        }

        // set the owning side of the relation if necessary
        if ($auth_user !== null && $auth_user->getTeacher() !== $this) {
            $auth_user->setTeacher($this);
        }

        $this->auth_user = $auth_user;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        // unset the owning side of the relation if necessary
        if ($course === null && $this->course !== null) {
            $this->course->setHomeTeacher(null);
        }

        // set the owning side of the relation if necessary
        if ($course !== null && $course->getHomeTeacher() !== $this) {
            $course->setHomeTeacher($this);
        }

        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection<int, Subject>
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject): static
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects->add($subject);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): static
    {
        $this->subjects->removeElement($subject);

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
            $test->setTeacher($this);
        }

        return $this;
    }

    public function removeTest(Test $test): static
    {
        if ($this->tests->removeElement($test)) {
            // set the owning side to null (unless already changed)
            if ($test->getTeacher() === $this) {
                $test->setTeacher(null);
            }
        }

        return $this;
    }
}
