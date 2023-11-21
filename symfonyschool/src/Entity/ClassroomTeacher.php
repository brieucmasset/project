<?php

namespace App\Entity;

use App\Repository\ClassroomTeacherRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassroomTeacherRepository::class)]
#[ORM\Table(name: 'classroom_teacher')]
class ClassroomTeacher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Relation Many-to-One avec la classe Classroom (chaque ClassroomTeacher est associé à une Classroom)
    #[ORM\ManyToOne(inversedBy: 'classroomTeachers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classroom $classroom = null;

    // Relation Many-to-One avec la classe Teacher (chaque ClassroomTeacher est associé à un Teacher)
    #[ORM\ManyToOne(inversedBy: 'classroomTeachers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Teacher $teacher = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): static
    {
        $this->classroom = $classroom;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): static
    {
        $this->teacher = $teacher;

        return $this;
    }
}
