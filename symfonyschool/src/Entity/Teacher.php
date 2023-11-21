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

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $sexe = null;

    // Relation Many-to-Many avec la classe Classroom (enseignants dans plusieurs classes)
    #[ORM\ManyToMany(targetEntity: Classroom::class, inversedBy: 'teachers')]
    private Collection $classroom;

    // Relation Many-to-Many avec la classe Discipline (enseignants enseignant plusieurs matières)
    #[ORM\ManyToMany(targetEntity: Discipline::class, mappedBy: 'teacher')]
    private Collection $disciplines;

    // Relation One-to-Many avec la classe ClassroomTeacher (enseignants associés à des classes)
    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: ClassroomTeacher::class)]
    private Collection $classroomTeachers;

    public function __construct()
    {
        $this->classroom = new ArrayCollection();
        $this->disciplines = new ArrayCollection();
        $this->classroomTeachers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @return Collection<int, Classroom>
     */
    public function getClassroom(): Collection
    {
        return $this->classroom;
    }

    public function addClassroom(Classroom $classroom): static
    {
        if (!$this->classroom->contains($classroom)) {
            $this->classroom->add($classroom);
        }

        return $this;
    }

    public function removeClassroom(Classroom $classroom): static
    {
        $this->classroom->removeElement($classroom);

        return $this;
    }

    /**
     * @return Collection<int, Discipline>
     */
    public function getDisciplines(): Collection
    {
        return $this->disciplines;
    }

    public function addDiscipline(Discipline $discipline): static
    {
        if (!$this->disciplines->contains($discipline)) {
            $this->disciplines->add($discipline);
            $discipline->addTeacher($this);
        }

        return $this;
    }

    public function removeDiscipline(Discipline $discipline): static
    {
        if ($this->disciplines->removeElement($discipline)) {
            $discipline->removeTeacher($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * @return Collection<int, ClassroomTeacher>
     */
    public function getClassroomTeachers(): Collection
    {
        return $this->classroomTeachers;
    }

    public function addClassroomTeacher(ClassroomTeacher $classroomTeacher): static
    {
        if (!$this->classroomTeachers->contains($classroomTeacher)) {
            $this->classroomTeachers->add($classroomTeacher);
            $classroomTeacher->setTeacher($this);
        }

        return $this;
    }

    public function removeClassroomTeacher(ClassroomTeacher $classroomTeacher): static
    {
        if ($this->classroomTeachers->removeElement($classroomTeacher)) {
            // Définit le côté propriétaire à null (sauf s'il a déjà été modifié)
            if ($classroomTeacher->getTeacher() === $this) {
                $classroomTeacher->setTeacher(null);
            }
        }

        return $this;
    }
}
