<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date_time = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date_time = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDateTime(): ?\DateTimeInterface
    {
        return $this->start_date_time;
    }

    public function setStartDateTime(\DateTimeInterface $start_date_time): static
    {
        $this->start_date_time = $start_date_time;

        return $this;
    }

    public function getEndDateTime(): ?\DateTimeInterface
    {
        return $this->end_date_time;
    }

    public function setEndDateTime(\DateTimeInterface $end_date_time): static
    {
        $this->end_date_time = $end_date_time;

        return $this;
    }
}
