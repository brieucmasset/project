<?php

namespace App\Controller;

use App\Entity\ClassroomTeacher;
use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\ClassroomRepository;
use App\Repository\ClassroomTeacherRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/teacher')]
class TeacherController extends AbstractController
{
    // Affiche la liste des enseignants
    #[Route('/', name: 'app_teacher_index', methods: ['GET'])]
    public function index(TeacherRepository $teacherRepository): Response
    {
        return $this->render('teacher/index.html.twig', [
            'teachers' => $teacherRepository->findAll(),
        ]);
    }

    // Crée un nouvel enseignant avec des classes associées
    #[Route('/new', name: 'app_teacher_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        TeacherRepository $teacherRepository,
        ClassroomRepository $classroomRepository,
        ClassroomTeacherRepository $classroomTeacherRepository
    ): Response
    {
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teacherRepository->save($teacher, true);

            foreach($request->get('classrooms') as $key => $val){
                // Récupération de l'objet de classe par rapport à l'ID
                $classroom = $classroomRepository->findOneById($val);

                // Crée un lien entre l'enseignant et la classe
                $classroomTeacher = new ClassroomTeacher();
                $classroomTeacher->setClassroom($classroom);
                $classroomTeacher->setTeacher($teacher);
                
                $classroomTeacherRepository->save($classroomTeacher, true);
            }

            return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teacher/new.html.twig', [
            'teacher' => $teacher,
            'classrooms' => $classroomRepository->findAll(),
            'form' => $form,
        ]);
    }

    // Affiche les détails d'un enseignant
    #[Route('/{id}', name: 'app_teacher_show', methods: ['GET'])]
    public function show(Teacher $teacher): Response
    {
        return $this->render('teacher/show.html.twig', [
            'teacher' => $teacher,
        ]);
    }

    // Édite un enseignant existant avec des classes associées
    #[Route('/{id}/edit', name: 'app_teacher_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Teacher $teacher,
        TeacherRepository $teacherRepository,
        ClassroomRepository $classroomRepository,
        ClassroomTeacherRepository $classroomTeacherRepository
    ): Response
    {
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teacherRepository->save($teacher, true);

            // Supprime les anciennes relations entre l'enseignant et les classes
            $oldRelation = $classroomTeacherRepository->findBy(['teacher' => $teacher->getId()]);
            foreach($oldRelation as $row){
                $classroomTeacherRepository->remove($row, true);
            }

            foreach($request->get('classrooms') as $key => $val){
                // Récupération de l'objet de classe par rapport à l'ID
                $classroom = $classroomRepository->findOneById($val);

                // Crée un nouveau lien entre l'enseignant et la classe
                $classroomTeacher = new ClassroomTeacher();
                $classroomTeacher->setClassroom($classroom);
                $classroomTeacher->setTeacher($teacher);
                
                $classroomTeacherRepository->save($classroomTeacher, true);
            }

            return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teacher/edit.html.twig', [
            'teacher' => $teacher,
            'classrooms' => $classroomRepository->findAll(),
            'form' => $form,
        ]);
    }

    // Supprime un enseignant
    #[Route('/{id}', name: 'app_teacher_delete', methods: ['POST'])]
    public function delete(Request $request, Teacher $teacher, TeacherRepository $teacherRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teacher->getId(), $request->request->get('_token'))) {
            $teacherRepository->remove($teacher, true);
        }

        return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
    }
}
