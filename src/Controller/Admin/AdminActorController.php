<?php

namespace App\Controller\Admin;

use App\Entity\Actor;
use App\Form\ActorType;
use App\Repository\ActorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/actor")
 */
class AdminActorController extends AbstractController
{
    /**
     * Constructeur pour initialiser le Repository.
     *
     * @var ActorRepository
     */
    public function __construct(ActorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="admin.actor.index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $actors = $paginator->paginate($this->repository->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('admin/actor/index.html.twig', [
            'actors' => $actors,
        ]);
    }

    /**
     * @Route("/new", name="admin.actor.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actor);
            $entityManager->flush();

            return $this->redirectToRoute('admin.actor.index');
        }

        return $this->render('admin/actor/new.html.twig', [
            'actor' => $actor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.actor.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Actor $actor): Response
    {
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.actor.index');
        }

        return $this->render('admin/actor/edit.html.twig', [
            'actor' => $actor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.actor.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Actor $actor): Response
    {
        if ($this->isCsrfTokenValid('admin/delete'.$actor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.actor.index');
    }
}
