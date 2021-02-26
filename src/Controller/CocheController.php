<?php

namespace App\Controller;

use App\Entity\Coche;
use App\Form\CocheType;
use App\Repository\CocheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cars")
 */
class CocheController extends AbstractController
{
    /**
     * @Route("/", name="coche_index", methods={"GET"})
     */
    public function index(CocheRepository $cocheRepository): Response
    {
        return $this->render('coche/index.html.twig', [
            'coches' => $cocheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="coche_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $coche = new Coche();
        $form = $this->createForm(CocheType::class, $coche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coche);
            $entityManager->flush();

            return $this->redirectToRoute('coche_index');
        }

        return $this->render('coche/new.html.twig', [
            'coche' => $coche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="coche_show", methods={"GET"})
     */
    public function show(Coche $coche): Response
    {
        return $this->render('coche/show.html.twig', [
            'coche' => $coche,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="coche_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Coche $coche): Response
    {
        $form = $this->createForm(CocheType::class, $coche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('coche_index');
        }

        return $this->render('coche/edit.html.twig', [
            'coche' => $coche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="coche_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Coche $coche): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coche->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coche);
            $entityManager->flush();
        }

        return $this->redirectToRoute('coche_index');
    }
}
