<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Curso;
use App\Repository\CursoRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Curso2Controller extends AbstractController
{

    /**
     * @Route("/curso2", name="curso2")
     */
    public function index(CursoRepository $cursoRepository): Response
    {
        
        $cursos = $cursoRepository->findAll();
        
        return $this->render('curso2/index.html.twig', [
            'controller_name' => 'CursoController',
            'courses' => $cursos
        ]);
    }

     /**
     * @Route("/curso2/add", name="curso2_add")
     */
    public function add(EntityManagerInterface $em): Response
    {
        $curso = new Curso();
        $curso->setNombre('Curso de Inglés');
        $curso->setIdioma('Inglés');
        $curso->setNivel(4);

        $curso2 = new Curso();
        $curso2->setNombre('Curso de Chino');
        $curso2->setIdioma('Chino');
        $curso2->setNivel(2);

        $alumno = new \App\Entity\Alumno();
        $alumno->setNombre('Carlos');
        $alumno->setEmail('Carlos@correo.es');

        $curso->addAlumno($alumno);
        
        $em->persist($curso);
        $em->persist($curso2);
        $em->persist($alumno);

        $em->flush();

        return new RedirectResponse('../curso');
    }

    /**
     * @Route("/curso2/{id}", name="curso2_show")
     */
    public function show($id, CursoRepository $cursoRepository, EntityManagerInterface $em): Response
    {
        
        $curso = $cursoRepository->find($id);

        $curso->setNivel(1);
        $curso->setIdioma('Francés');
        $em->persist($curso);
        $em->flush();

        
        return $this->render('curso2/show.html.twig', [
            'item' => $curso
        ]);
    }

    /**
     * @Route("/curso2/filter/{language}", name="curso2_filter")
     */
    public function filter($language, CursoRepository $cursoRepository): Response
    {
        
        // $cursos = $cursoRepository->findByIdioma($language);
        // $curso = $cursoRepository->findOneByIdioma($language);
        $cursos = $cursoRepository->findBy(['idioma' => $language, 'nivel' => 2], ['nombre' => 'ASC'], 10, 3);
        //           SELECT * FROM Curso WHERE idioma = 'Chino' AND nivel = 2 ORDER BY nombre ASC LIMIT 10 SKIP 3

        // SELECT * FROM Curso WHERE idioma = 'Chino' LIMIT 1
        
        return $this->render('curso2/index.html.twig', [
            'courses' => $cursos
        ]);
    }

    

   
}
