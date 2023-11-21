<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\ClassroomTeacher;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use App\Repository\ClassroomTeacherRepository;
use App\Repository\TeacherRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Contrôleur pour gérer les opérations CRUD des salles de classe
#[Route('/classroom')]
class ClassroomController extends AbstractController
{
    // Injection de RequestStack pour gérer les sessions
    public function __construct(private RequestStack $requestStack)
    {
    }

    // Affiche la liste des salles de classe
    #[Route('/', name: 'app_classroom_index', methods: ['GET'])]
    public function index(ClassroomRepository $classroomRepository): Response
    {
        // Accès aux sessions
        $session = $this->requestStack->getSession();
        $name = $session->get('name');

        return $this->render('classroom/index.html.twig', [
            'classrooms' => $classroomRepository->findAll(),
        ]);
    }

    // Crée une nouvelle salle de classe
    #[Route('/new', name: 'app_classroom_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        ClassroomRepository $classroomRepository,
        TeacherRepository $teacherRepository,
        ClassroomTeacherRepository $classroomTeacherRepository
    ): Response {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $classroomRepository->save($classroom, true);

                // Gestion des enseignants associés à la salle de classe
                foreach ($request->get('teachers') as $key => $val) {
                    $teacher = $teacherRepository->findOneById($val);
                    $classroomTeacher = new ClassroomTeacher();
                    $classroomTeacher->setClassroom($classroom);
                    $classroomTeacher->setTeacher($teacher);
                    $classroomTeacherRepository->save($classroomTeacher, true);
                }

                // Message de succès
                $this->addFlash(
                    'success',
                    'Votre salle de classe a bien été enregistrée'
                );
            } catch (Exception $ex) {
                // En cas d'erreur, affiche un message d'avertissement
                $this->addFlash(
                    'warning',
                    'Une erreur s\'est produite. Merci de contacter votre administrateur'
                );
            }

            // Redirection vers la liste des salles de classe
            return $this->redirectToRoute('app_classroom_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classroom/new.html.twig', [
            'teachers' => $teacherRepository->findAll(),
            'form' => $form,
        ]);
    }

    // Affiche les détails d'une salle de classe spécifique
    #[Route('/{id}', name: 'app_classroom_show', methods: ['GET'])]
    public function show(Classroom $classroom): Response
    {
        return $this->render('classroom/show.html.twig', [
            'classroom' => $classroom,
        ]);
    }

    // Modifie une salle de classe existante
    #[Route('/{id}/edit', name: 'app_classroom_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Classroom $classroom,
        ClassroomRepository $classroomRepository,
        TeacherRepository $teacherRepository,
        ClassroomTeacherRepository $classroomTeacherRepository
    ): Response {
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classroomRepository->save($classroom, true);

            // Supprime toutes les relations d'enseignants existantes avant d'ajouter les nouvelles
            $oldRelation = $classroomTeacherRepository->findBy(['classroom' => $classroom->getId()]);
            foreach ($oldRelation as $row) {
                $classroomTeacherRepository->remove($row, true);
            }

            // Gestion des enseignants associés à la salle de classe
            foreach ($request->get('teachers') as $key => $val) {
                $teacher = $teacherRepository->findOneById($val);
                $classroomTeacher = new ClassroomTeacher();
                $classroomTeacher->setClassroom($classroom);
                $classroomTeacher->setTeacher($teacher);
                $classroomTeacherRepository->save($classroomTeacher, true);
            }

            // Redirection vers la liste des salles de classe
            return $this->redirectToRoute('app_classroom_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classroom/edit.html.twig', [
            'classroom' => $classroom,
            'teachers' => $teacherRepository->findAll(),
            'form' => $form,
        ]);
    }

    // Supprime une salle de classe
    #[Route('/delete/{id}', name: 'app_classroom_delete')]
    public function delete(Request $request, Classroom $classroom, ClassroomRepository $classroomRepository): Response
    {
        $classroomRepository->remove($classroom, true);

        // Redirection vers la liste des salles de classe
        return $this->redirectToRoute('app_classroom_index', [], Response::HTTP_SEE_OTHER);
    }
}
