<?php

namespace App\Controller;

use App\Entity\Shift;
use App\Form\ShiftType;
use App\Repository\ShiftRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/shift')]
final class ShiftController extends AbstractController
{
    #[Route(name: 'app_shift_index', methods: ['GET'])]
    public function index(ShiftRepository $shiftRepository): Response
    {
        return $this->render('shift/index.html.twig', [
            'shifts' => $shiftRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_shift_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $shift = new Shift();
        $form = $this->createForm(ShiftType::class, $shift);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($shift);
            $entityManager->flush();

            return $this->redirectToRoute('app_shift_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('shift/new.html.twig', [
            'shift' => $shift,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shift_show', methods: ['GET'])]
    public function show(Shift $shift): Response
    {
        return $this->render('shift/show.html.twig', [
            'shift' => $shift,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_shift_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Shift $shift, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ShiftType::class, $shift);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_shift_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('shift/edit.html.twig', [
            'shift' => $shift,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shift_delete', methods: ['POST'])]
    public function delete(Request $request, Shift $shift, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shift->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($shift);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_shift_index', [], Response::HTTP_SEE_OTHER);
    }
}
