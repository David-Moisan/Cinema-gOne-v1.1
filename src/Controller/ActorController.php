<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    /**
     * @var ActorRepository
     */
    private $repository;

    public function __construct(ActorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Méthode index de la page acteurs.
     *
     * @Route("/acteurs", name="actor.index")
     *
     * @return Response
     */
    public function index(): Response
    {
        $actors = $this->repository->findAll();

        return $this->render('actor/index.html.twig', [
            'actors' => $actors,
        ]);
    }

    /**
     * Méthode show pour la page acteurs.
     *
     * @Route("/acteurs/{id}", name="actor.show")
     *
     * @return void
     */
    public function show(Actor $actor): Response
    {
        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }
}
