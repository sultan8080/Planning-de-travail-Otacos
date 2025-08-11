<?php

namespace App\Controller;

use App\Entity\Branch;
use App\Form\BranchType;
use App\Repository\BranchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/branch')]
final class BranchController extends AbstractController
{
    #[Route(name: 'app_branch_index', methods: ['GET'])]
    public function index(BranchRepository $branchRepository): Response
    {
        return $this->render('branch/index.html.twig', [
            'branches' => $branchRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_branch_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $branch = new Branch();
        $form = $this->createForm(BranchType::class, $branch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($branch);
            $entityManager->flush();

            return $this->redirectToRoute('app_branch_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('branch/new.html.twig', [
            'branch' => $branch,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_branch_show', methods: ['GET'])]
    public function show(Branch $branch): Response
    {
        return $this->render('branch/show.html.twig', [
            'branch' => $branch,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_branch_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Branch $branch, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BranchType::class, $branch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_branch_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('branch/edit.html.twig', [
            'branch' => $branch,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_branch_delete', methods: ['POST'])]
    public function delete(Request $request, Branch $branch, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$branch->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($branch);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_branch_index', [], Response::HTTP_SEE_OTHER);
    }
}
