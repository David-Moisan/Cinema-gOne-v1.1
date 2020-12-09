<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function index(MovieRepository $repository): Response
    {
        $movies = $repository->findLast();

        return $this->render('pages/home.html.twig', [
            'movies' => $movies,
        ]);
    }
}
