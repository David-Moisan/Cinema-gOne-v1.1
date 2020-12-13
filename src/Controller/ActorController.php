<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    /**
     * Méthode index pour les acteurs.
     *
     * @Route("/acteurs", name="actor.index")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('actor/index.html.twig');
    }
}
