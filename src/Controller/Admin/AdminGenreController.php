<?php

namespace App\Controller\Admin;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/genre")
 */
class AdminGenreController extends AbstractController
{
    /**
     * @Route("/", name="admin.genre.index", methods={"GET"})
     */
    public function index(GenreRepository $genreRepository): Response
    {
        return $this->render('/admin/genre/index.html.twig', [
            'genres' => $genreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.genre.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($genre);
            $entityManager->flush();

            return $this->redirectToRoute('admin.genre.index');
        }

        return $this->render('/admin/genre/new.html.twig', [
            'genre' => $genre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.genre.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Genre $genre): Response
    {
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.genre.index');
        }

        return $this->render('/admin/genre/edit.html.twig', [
            'genre' => $genre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.genre.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Genre $genre): Response
    {
        if ($this->isCsrfTokenValid('/admin/delete'.$genre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($genre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.genre.index');
    }
}
