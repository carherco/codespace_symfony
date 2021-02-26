<?php

namespace App\Controller;

use App\Entity\Curso;
use App\Form\CursoType;
use App\Repository\CursoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/curso")
 */
class ApiCursoController extends AbstractController
{
    /**
     * @Route("/", name="api_curso_index", methods={"GET"})
     */
    public function index(CursoRepository $cursoRepository): Response
    {
        $cursos = $cursoRepository->findAll();
        
        $cursosArray = [];
        foreach($cursos as $curso) {

            $cursoArray = $this->serializeCurso($curso);

            $cursosArray[] = $cursoArray;
        }
        return new JsonResponse($cursosArray);
    }

    /**
     * @Route("/new", name="api_curso_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $bodyRequest = $request->getContent();
        $cursoObj = json_decode($bodyRequest);

        $curso = new Curso();
        $curso->setNombre( $cursoObj->nombre );
        $curso->setIdioma( $cursoObj->idioma );
        $curso->setNivel( $cursoObj->nivel );

        $em->persist($curso);
        $em->flush();

        $respuesta=[
            'id'=>$curso->getId(),
            'nombre'=>$curso->getNombre(),
            'idioma'=>$curso->getIdioma(),
            'nivel'=>$curso->getNivel(),
        ];
        return new JsonResponse($respuesta);
    }

    /**
     * @Route("/{id}", name="api_curso_show", methods={"GET"})
     */
    public function show($id, CursoRepository $cursoRepository): Response
    {
        
        $curso = $cursoRepository->find($id);

        if($curso === null) {
            throw $this->createNotFoundException('El curso no existe');
        }

        $cursoArray = $this->serializeCurso($curso);

        return new JsonResponse($cursoArray);

    }

    private function serializeCurso(Curso $curso) {
        $alumnosArray=[];

        $alumnos=$curso->getAlumnos();  // Array de entidades Alumno
        foreach($alumnos as $alumno){
            $alumnoArray=[
                'id'=>$alumno->getId(),
                'nombre'=>$alumno->getNombre(),
                'email'=>$alumno->getEmail()
            ];
            $alumnosArray[]=$alumnoArray; // array_push($alumnosArray, $alumnoArray)
        }

        $cursoArray=[
            'id'=>$curso->getId(),
            'nombre'=>$curso->getNombre(),
            'idioma'=>$curso->getIdioma(),
            'nivel'=>$curso->getNivel(),
            'alumnos'=>$alumnosArray
        ];

        return $cursoArray;
    }

    /**
     * @Route("/{id}", name="curso_edit", methods={"PUT"})
     */
    public function edit(Request $request, Curso $curso): Response
    {
        
    }

    // /**
    //  * @Route("/{id}", name="curso_delete", methods={"DELETE"})
    //  */
    // public function delete(Request $request, Curso $curso): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$curso->getId(), $request->request->get('_token'))) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($curso);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('curso_index');
    // }
}