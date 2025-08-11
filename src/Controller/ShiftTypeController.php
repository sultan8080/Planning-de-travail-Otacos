<?php

namespace App\Controller;

use App\Entity\ShiftType;
use App\Form\ShiftTypeType;
use App\Repository\ShiftTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/shift/type')]
final class ShiftTypeController extends AbstractController
{
    #[Route(name: 'app_shift_type_index', methods: ['GET'])]
    public function index(ShiftTypeRepository $shiftTypeRepository): Response
    {
        return $this->render('shift_type/index.html.twig', [
            'shift_types' => $shiftTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_shift_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $shiftType = new ShiftType();
        $form = $this->createForm(ShiftTypeType::class, $shiftType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($shiftType);
            $entityManager->flush();

            return $this->redirectToRoute('app_shift_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('shift_type/new.html.twig', [
            'shift_type' => $shiftType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shift_type_show', methods: ['GET'])]
    public function show(ShiftType $shiftType): Response
    {
        return $this->render('shift_type/show.html.twig', [
            'shift_type' => $shiftType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_shift_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ShiftType $shiftType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ShiftTypeType::class, $shiftType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_shift_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('shift_type/edit.html.twig', [
            'shift_type' => $shiftType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shift_type_delete', methods: ['POST'])]
    public function delete(Request $request, ShiftType $shiftType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shiftType->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($shiftType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_shift_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
