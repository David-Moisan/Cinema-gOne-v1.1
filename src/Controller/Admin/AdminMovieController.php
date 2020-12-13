<?php

namespace App\Controller\Admin;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminMovieController extends AbstractController
{
    /**
     * @var MovieRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(MovieRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * Méthode index de la partie Admin qui permet de gérer tous les films à afficher sur l'app.
     *
     * @Route("/admin", name="admin.movie.index")
     *
     * @return void
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $movies = $paginator->paginate($this->repository->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('admin/movie/index.html.twig', compact('movies'));
    }

    /**
     * Méthode new pour créer un nouveau film.
     *
     * @Route("/admin/films/creer", name="admin.movie.new")
     *
     * @return void
     */
    public function new(Request $request)
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($movie);
            $this->em->flush();
            $this->addFlash('success', 'Film créé avec succès');

            return $this->redirectToRoute('admin.movie.index'); //redirection vers le listing des films
        }

        return $this->render('admin/movie/new.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode edit pour éditer les informations des films.
     *
     * @Route("/admin/films/{id}", name="admin.movie.edit", methods="GET|POST")
     *
     * @return void
     */
    public function edit(Movie $movie, Request $request)
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Film modifié avec succès');

            return $this->redirectToRoute('admin.movie.index'); //redirection vers le listing des films
        }

        return $this->render('admin/movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode delete pour supprimer un film de la liste.
     *
     * @Route("/admin/films/{id}", name="admin.movie.delete", methods="DELETE")
     *
     * @return void
     */
    public function delete(Movie $movie, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$movie->getId(), $request->get('_token'))) {
            $this->em->remove($movie);
            $this->em->flush();
            $this->addFlash('success', 'Film supprimer avec succès');
        }

        return $this->redirectToRoute('admin.movie.index');
    }
}
