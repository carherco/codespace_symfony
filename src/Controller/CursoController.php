<?php

namespace App\Controller;

use App\Entity\Curso;
use App\Form\CursoType;
use App\Repository\CursoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/curso")
 */
class CursoController extends AbstractController
{
    /**
     * @Route("/", name="curso_index", methods={"GET"})
     */
    public function index(CursoRepository $cursoRepository): Response
    {
        return $this->render('curso/index.html.twig', [
            'cursos' => $cursoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="curso_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $curso = new Curso();
        $form = $this->createForm(CursoType::class, $curso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($curso);
            $entityManager->flush();

            return $this->redirectToRoute('curso_index');
        }

        return $this->render('curso/new.html.twig', [
            'curso' => $curso,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="curso_show", methods={"GET"})
     */
    public function show(Curso $curso): Response
    {
        return $this->render('curso/show.html.twig', [
            'curso' => $curso,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="curso_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Curso $curso): Response
    {
        $form = $this->createForm(CursoType::class, $curso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('curso_index');
        }

        return $this->render('curso/edit.html.twig', [
            'curso' => $curso,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="curso_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Curso $curso): Response
    {
        if ($this->isCsrfTokenValid('delete'.$curso->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($curso);
            $entityManager->flush();
        }

        return $this->redirectToRoute('curso_index');
    }
}
