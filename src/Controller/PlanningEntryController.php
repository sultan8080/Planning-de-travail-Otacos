<?php

namespace App\Controller;

use App\Entity\PlanningEntry;
use App\Form\PlanningEntryType;
use App\Repository\PlanningEntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/planning/entry')]
final class PlanningEntryController extends AbstractController
{
    #[Route(name: 'app_planning_entry_index', methods: ['GET'])]
    public function index(PlanningEntryRepository $planningEntryRepository): Response
    {
        return $this->render('planning_entry/index.html.twig', [
            'planning_entries' => $planningEntryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_planning_entry_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $planningEntry = new PlanningEntry();
        $form = $this->createForm(PlanningEntryType::class, $planningEntry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($planningEntry);
            $entityManager->flush();

            return $this->redirectToRoute('app_planning_entry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('planning_entry/new.html.twig', [
            'planning_entry' => $planningEntry,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planning_entry_show', methods: ['GET'])]
    public function show(PlanningEntry $planningEntry): Response
    {
        return $this->render('planning_entry/show.html.twig', [
            'planning_entry' => $planningEntry,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_planning_entry_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlanningEntry $planningEntry, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanningEntryType::class, $planningEntry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_planning_entry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('planning_entry/edit.html.twig', [
            'planning_entry' => $planningEntry,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planning_entry_delete', methods: ['POST'])]
    public function delete(Request $request, PlanningEntry $planningEntry, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planningEntry->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($planningEntry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_planning_entry_index', [], Response::HTTP_SEE_OTHER);
    }
}
