<?php

namespace App\Controller;

use App\Entity\Marge;
use App\Form\Marge1Type;
use App\Repository\MargeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/marge')]
class MargeController extends AbstractController
{
    #[Route('/', name: 'app_marge_index', methods: ['GET'])]
    public function index(MargeRepository $margeRepository): Response
    {
        return $this->render('marge/index.html.twig', [
            'marges' => $margeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_marge_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $marge = new Marge();
        $form = $this->createForm(Marge1Type::class, $marge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($marge);
            $entityManager->flush();

            return $this->redirectToRoute('app_marge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marge/new.html.twig', [
            'marge' => $marge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_marge_show', methods: ['GET'])]
    public function show(Marge $marge): Response
    {
        return $this->render('marge/show.html.twig', [
            'marge' => $marge,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_marge_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Marge $marge, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Marge1Type::class, $marge);
        $form->handleRequest($request);
        $user = $this->getUser();

        //$margeBH_achat = (($marge->getCours()->getCoursBHAchat() / $marge->getCours()->getCoursBCTAchat()) - 1) * -100;
        //$margeBH_vente = (($marge->getCours()->getCoursBHVente() / $marge->getCours()->getCoursBCTVente() ) - 1) * 100;





        if ($form->isSubmitted() && $form->isValid()) {
            $coursBH_achat = $marge->getCours()->getCoursBCTAchat() * (1 - ($marge->getMargeAchat() / 100));
            $marge->getCours()->setCoursBHAchat($coursBH_achat);

            $coursBH_vente = $marge->getCours()->getCoursBCTVente() * (1 + ($marge->getMargeVente() / 100));
            $marge->getCours()->setCoursBHVente($coursBH_vente);
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_by_marche', ['id'=>$marge->getCours()->getMarche()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marge/edit.html.twig', [
            'marge' => $marge,
            'form' => $form,
            'user' => $user
        ]);
    }

    #[Route('/{id}', name: 'app_marge_delete', methods: ['POST'])]
    public function delete(Request $request, Marge $marge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marge->getId(), $request->request->get('_token'))) {
            $entityManager->remove($marge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_marge_index', [], Response::HTTP_SEE_OTHER);
    }
}
