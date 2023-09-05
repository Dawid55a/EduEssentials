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

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: Student::class)]
    private Collection $students;

    #[ORM\OneToOne(inversedBy: 'course', cascade: ['persist', 'remove'])]
    private ?Teacher $home_teacher = null;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: CourseSubject::class)]
    private Collection $courseSubjects;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->courseSubjects = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
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

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setCourse($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getCourse() === $this) {
                $student->setCourse(null);
            }
        }

        return $this;
    }

    public function getHomeTeacher(): ?Teacher
    {
        return $this->home_teacher;
    }

    public function setHomeTeacher(?Teacher $home_teacher): static
    {
        $this->home_teacher = $home_teacher;

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
            $courseSubject->setCourse($this);
        }

        return $this;
    }

    public function removeCourseSubject(CourseSubject $courseSubject): static
    {
        if ($this->courseSubjects->removeElement($courseSubject)) {
            // set the owning side to null (unless already changed)
            if ($courseSubject->getCourse() === $this) {
                $courseSubject->setCourse(null);
            }
        }

        return $this;
    }
}
