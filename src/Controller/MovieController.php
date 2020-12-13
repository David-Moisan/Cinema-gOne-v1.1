<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\MovieSearch;
use App\Form\MovieSearchType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
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
     * Méthode index des films.
     *
     * @Route("/films", name="movie.index")
     *
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new MovieSearch();
        $form = $this->createForm(MovieSearchType::class, $search);
        $form->handleRequest($request);
        $movies = $paginator->paginate($this->repository->findAllVisible($search),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Méthode pour voir la page de chaque film individuellement.
     *
     * @Route("/films/{slug}-{id}", name="movie.show", requirements={"slug": "[a-z0-9\-]*"})
     *
     * @return Response
     */
    public function show(Movie $movie, string $slug): Response
    {
        if ($movie->getSlug() !== $slug) {
            return $this->redirectToRoute('movie.show', [
                'id' => $movie->getId(),
                'slug' => $movie->getSlug(),
            ], 301);
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }
}
