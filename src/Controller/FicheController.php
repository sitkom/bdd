<?php

namespace App\Controller;

use App\Entity\Fiche;
use App\Form\FicheType;
use App\Repository\FicheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fiche")
 */
class FicheController extends AbstractController
{
    /**
     * @Route("/", name="fiche_index", methods={"GET"})
     */
    public function index(FicheRepository $ficheRepository): Response
    {
        return $this->render('fiche/index.html.twig', [
            'fiches' => $ficheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="fiche_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fiche = new Fiche();
        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fiche);
            $entityManager->flush();

            return $this->redirectToRoute('fiche_index');
        }

        return $this->render('fiche/new.html.twig', [
            'fiche' => $fiche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fiche_show", methods={"GET"})
     */
    public function show(Fiche $fiche): Response
    {
        return $this->render('fiche/show.html.twig', [
            'fiche' => $fiche,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fiche_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fiche $fiche): Response
    {
        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fiche_index');
        }

        return $this->render('fiche/edit.html.twig', [
            'fiche' => $fiche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fiche_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Fiche $fiche): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fiche->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fiche);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fiche_index');
    }
}
