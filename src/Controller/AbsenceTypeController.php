<?php

namespace App\Controller;

use App\Entity\AbsenceType;
use App\Form\AbsenceTypeType;
use App\Repository\AbsenceTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/absence/type')]
final class AbsenceTypeController extends AbstractController
{
    #[Route(name: 'app_absence_type_index', methods: ['GET'])]
    public function index(AbsenceTypeRepository $absenceTypeRepository): Response
    {
        return $this->render('absence_type/index.html.twig', [
            'absence_types' => $absenceTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_absence_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $absenceType = new AbsenceType();
        $form = $this->createForm(AbsenceTypeType::class, $absenceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($absenceType);
            $entityManager->flush();

            return $this->redirectToRoute('app_absence_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('absence_type/new.html.twig', [
            'absence_type' => $absenceType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_absence_type_show', methods: ['GET'])]
    public function show(AbsenceType $absenceType): Response
    {
        return $this->render('absence_type/show.html.twig', [
            'absence_type' => $absenceType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_absence_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AbsenceType $absenceType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AbsenceTypeType::class, $absenceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_absence_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('absence_type/edit.html.twig', [
            'absence_type' => $absenceType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_absence_type_delete', methods: ['POST'])]
    public function delete(Request $request, AbsenceType $absenceType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$absenceType->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($absenceType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_absence_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
