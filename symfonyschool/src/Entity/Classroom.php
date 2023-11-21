<?php

namespace App\Entity;

use App\Repository\ClassroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassroomRepository::class)]
class Classroom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $capacity = null;

    // Relation One-to-Many avec la classe Student (chaque Classroom peut avoir plusieurs étudiants)
    #[ORM\OneToMany(mappedBy: 'classroom', targetEntity: Student::class)]
    private Collection $student;

    // Relation One-to-Many avec la classe ClassroomTeacher (chaque Classroom peut avoir plusieurs relations ClassroomTeacher)
    #[ORM\OneToMany(mappedBy: 'classroom', targetEntity: ClassroomTeacher::class)]
    private Collection $classroomTeachers;

    // Relation Many-to-Many avec la classe Teacher (chaque Classroom peut être associé à plusieurs enseignants)
    #[ORM\ManyToMany(targetEntity: Teacher::class, mappedBy: 'classroom')]
    private Collection $teachers;

    public function __construct()
    {
        $this->student = new ArrayCollection();
        $this->teachers = new ArrayCollection();
        $this->classroomTeachers = new ArrayCollection();
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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudent(): Collection
    {
        return $this->student;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->student->contains($student)) {
            $this->student->add($student);
            $student->setClassroom($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->student->removeElement($student)) {
            // Réglez le côté propriétaire sur null (sauf s'il a déjà changé)
            if ($student->getClassroom() === $this) {
                $student->setClassroom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Teacher>
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(Teacher $teacher): static
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers->add($teacher);
            $teacher->addClassroom($this);
        }

        return $this;
    }

    public function removeTeacher(Teacher $teacher): static
    {
        if ($this->teachers->removeElement($teacher)) {
            $teacher->removeClassroom($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
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
            $classroomTeacher->setClassroom($this);
        }

        return $this;
    }

    public function removeClassroomTeacher(ClassroomTeacher $classroomTeacher): static
    {
        if ($this->classroomTeachers->removeElement($classroomTeacher)) {
            // Réglez le côté propriétaire sur null (sauf s'il a déjà changé)
            if ($classroomTeacher->getClassroom() === $this) {
                $classroomTeacher->setClassroom(null);
            }
        }

        return $this;
    }
}
