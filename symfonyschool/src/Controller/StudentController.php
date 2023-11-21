<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/student')]
class StudentController extends AbstractController
{
    // Annotation pour empêcher les non-administrateurs d'accéder à la page
    //#[IsGranted('ROLE_ADMIN')]
    #[Route('/list', name: 'app_student')]
    public function index(StudentRepository $studentRepository): Response
    {
        // Récupération des données de la base de données dans le contrôleur en utilisant le référentiel (Doctrine)
        $listStudent = $studentRepository->findAll();

        return $this->render('student/index.html.twig', [
            // Passage de la variable à Twig
            'listStudent' => $listStudent
        ]);
    }

    #[Route('/details/{id}', name: 'app_student_details')]
    public function details(Student $student): Response
    {
        // Fonction pour empêcher les non-administrateurs d'accéder à la page
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('student/details.html.twig', [
            'student' => $student
        ]);
    }

    #[Route('/add', name: 'app_student_add')]
    public function add(StudentRepository $studentRepository, Request $request): Response
    {
        // Instanciation d'un objet vide pour qu'il soit ensuite hydraté par le formulaire
        $student = new Student();

        // Appel du formulaire
        $form = $this->createForm(StudentType::class, $student);
        // HandleRequest récupère les données en GET ou en POST
        // et s'occupe d'hydrater l'objet $student avec les données du formulaire
        $form->handleRequest($request);

        // On entre dans cette condition si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On donne au référentiel, via la méthode save, l'objet student
            // qui contient déjà toutes les informations
            $studentRepository->save($student, true);
            // On redirige l'utilisateur vers la liste des étudiants
            // pour qu'il voie immédiatement le résultat
            return $this->redirectToRoute('app_student');
        }

        // On envoie le formulaire à la vue Twig
        return $this->render('student/add.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/delete/{id}', name: 'app_student_delete')]
    public function delete(Student $student, StudentRepository $studentRepository): Response
    {
        // Suppression de la base de données via le référentiel de student
        $studentRepository->remove($student, true);

        // Redirection de l'utilisateur vers la page de la liste des étudiants
        return $this->redirectToRoute('app_student');
    }

    #[Route('/edit/{id}', name: 'app_student_edit')]
    public function edit(Student $student, StudentRepository $studentRepository, Request $request): Response
    {
        // Appel du formulaire
        $form = $this->createForm(StudentType::class, $student);
        // HandleRequest récupère les données en GET ou en POST
        // et s'occupe d'hydrater l'objet $student avec les données du formulaire
        $form->handleRequest($request);

        // On entre dans cette condition si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On donne au référentiel, via la méthode save, l'objet student
            // qui contient déjà toutes les informations
            $studentRepository->save($student, true);
            // On redirige l'utilisateur vers la liste des étudiants
            // pour qu'il voie immédiatement le résultat
            return $this->redirectToRoute('app_student');
        }

        // On envoie le formulaire à la vue Twig
        return $this->render('student/edit.html.twig', [
            'form' => $form
        ]);
    }
}
