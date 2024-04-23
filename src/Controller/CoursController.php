<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Marge;
use App\Form\CoursType;
use App\Entity\Marche;
use App\Repository\DeviseRepository;
use App\Repository\MarcheRepository;
use App\Repository\CoursRepository;
use Twilio\Rest\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class CoursController extends AbstractController
{
   
    #[Route('/coo', name: 'app_cours_index')]
    public function index(CoursRepository $Crepo): Response
    {
        $ccc=$Crepo->findAll();
        return $this->render('menu/index.html.twig', [
            'ccc' => $ccc,
        ]);
    }

    #[Route('/nouveau', name: 'app_cours_new', methods: ['GET', 'POST'])]
    public function new(MailerInterface $mailer,Request $request, EntityManagerInterface $entityManager,MarcheRepository $MRepo,DeviseRepository $DevRepo, CoursRepository $CRepo): Response
    {
        $marche=$MRepo->findAll();
        $devise=$DevRepo->findAll();
        $ccc= $CRepo->findAll();
        
   
       
        $user = $this->getUser();
        $cour = new Cours();

        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //email
            $email = (new Email())
            ->from('khalil.belhedi@esprit.tn')
            ->to('khalillloubelhedi@gmail.com')
            
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        
           
            return $this->redirectToRoute('app_cours_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form,
            'marche'=>$marche,
            'user' => $user,
            'devise' => $devise,

            'ccc' => $ccc,
            
        ]);
    }

   

    #[Route('/{id}/modifier', name: 'app_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_marche', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    #[Route('supprimer/{id}', name: 'app_cours_delete', methods: ['POST'])]
    public function delete(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_marche', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('marche/{id}', name: 'app_par_marche', methods: ['GET', 'POST'])]
    public function AfficheParmarche(Request $request,EntityManagerInterface $entityManager,Marche $marche,$id,DeviseRepository $DevRepo,MarcheRepository $marcheRepository,CoursRepository $coursRepository): Response
    { 

        $mm=$marcheRepository->findAll();
        $devise=$DevRepo->findAll();
        $ccc= $marche->getCours();
        
   
       
        $user = $this->getUser();
        $cour = new Cours();

        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $C = $coursRepository->findOneBy(['devise'=>$cour->getDevise()]);
            $margeBH_achat = (($cour->getCoursBHAchat() / $cour->getCoursBCTAchat()) - 1) * -100;
            $margeBH_vente = (($cour->getCoursBHVente() / $cour->getCoursBCTVente()) - 1) * 100;
            if ($C){
                $C
                    ->setCoursBHAchat($cour->getCoursBHAchat())
                    ->setCoursBHVente($cour->getCoursBHVente())
                    ->setCoursBHVente($cour->getCoursBCTAchat())
                    ->setCoursBHVente($cour->getCoursBCTVente())
                    ->setDate($cour->getDate());


                $C->getMarge()->setMargeAchat($margeBH_achat);
                $C->getMarge()->setMargeVente($margeBH_vente);
                $C->getMarge()->setDateMiseJour(new \DateTime());
            }else {
                $cour->setEtat(0);
                $cour->setMarche($marche);
                $marge = new Marge();
                $marge->setCours($cour);
                $marge->setMargeAchat($margeBH_achat);
                $marge->setMargeVente($margeBH_vente);
                $marge->setDateMiseJour(new \DateTime());
                $entityManager->persist($cour);
                $entityManager->persist($marge);
            }
            $entityManager->flush();
            return $this->redirectToRoute('app_par_marche', ['id' => $marche->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form,
            'marche'=>$mm,
            'user' => $user,
            'devise' => $devise,
            'ccc' => $ccc,
            
        ]);
    }


}
