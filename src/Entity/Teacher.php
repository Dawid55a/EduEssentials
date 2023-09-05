<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

//TODO: Check why the serialization context is not working
#[ORM\Entity(repositoryClass: TeacherRepository::class)]
#[ApiResource(
    description: 'Teachers are users with a role of teacher',
    operations: [
        new Get(),
        new GetCollection(),
    ],
    normalizationContext: ['groups' => ['teacher:read'], 'jsonld_embed_context' => true],
    paginationEnabled: false,
)]
class Teacher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['teacher:read'])]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: 'teacher', cascade: ['persist', 'remove'])]
    private ?User $auth_user = null;

    #[ORM\OneToOne(mappedBy: 'home_teacher', cascade: ['persist', 'remove'])]
    private ?Course $course = null;


    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: Test::class, orphanRemoval: true)]
    private Collection $tests;

    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: CourseSubject::class)]
    private Collection $courseSubjects;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
        $this->courseSubjects = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getAuthUser()->getFullName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Groups(['teacher:read', 'user:read'])]
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

    #[Groups(['teacher:read', 'course:read'])]
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
            $courseSubject->setTeacher($this);
        }

        return $this;
    }

    public function removeCourseSubject(CourseSubject $courseSubject): static
    {
        if ($this->courseSubjects->removeElement($courseSubject)) {
            // set the owning side to null (unless already changed)
            if ($courseSubject->getTeacher() === $this) {
                $courseSubject->setTeacher(null);
            }
        }

        return $this;
    }
}
