<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Marche;
use App\Entity\Marge;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use App\Repository\DeviseRepository;
use App\Repository\MarcheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(CoursRepository $Crepo,MarcheRepository $MRepo): Response
    {   $user = $this->getUser();
        $ccc=$Crepo->findAll();
        $marche=$MRepo->findAll();
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $user,
            'ccc' => $ccc,
            'marche' => $marche
        ]);
    }


    #[Route('admin/valider/{id}', name: 'app_cours_valider')]
    public function valider($id,Request $request, Cours $cours, CoursRepository $Crepo,EntityManagerInterface $em): Response
    {

        $res=$Crepo->find($id);
        $res->setEtat(1);
        $em=$this->getDoctrine()->getManager();

        $em->flush();

        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('admin/menu', name: 'admin_menu')]
    public function menu(MarcheRepository $MRepo,DeviseRepository $DevRepo,CoursRepository $Crepo): Response
    {
        $ccc=$Crepo->findAll();
        $marche=$MRepo->findAll();
        $devise=$DevRepo->findAll();
        $user = $this->getUser();
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
            'marche'=>$marche,
            'user' => $user,
            'devise' => $devise,
            'ccc' => $ccc

        ]);
    }
    #[Route('/admin/fetch', name: 'admin_marche')]
    public function indexx(MarcheRepository $MRepo,DeviseRepository $DevRepo ,CoursRepository $Crepo, Security $security): Response
    {
        $ccc=$Crepo->findAll();
        $march=$MRepo->findAll();
        $devise=$DevRepo->findAll();
        $user = $this->getUser();
        if ($security->isGranted('ROLE_ADMIN')) {

            return $this->render('admin/dashboard.html.twig',[
                'controller_name' => 'AdminController',
                'marche'=>$march,
                'user' => $user,
                'devise' => $devise,
                'ccc' => $ccc
            ]);

        }
        return $this->render('admin/listeDesCours.html.twig', [
            'controller_name' => 'AdminController',
            'march'=>$march,
            'user' => $user,
            'devise' => $devise,
            'ccc' => $ccc
        ]);
    }
    #[Route('/{id}/admin', name: 'admin_par_marche')]
    public function index_marche(Marche $marche,MarcheRepository $MRepo,DeviseRepository $DevRepo ,CoursRepository $Crepo): Response
    {
        $ccc=$marche->getCours();
        $marche=$MRepo->findAll();
        $devise=$DevRepo->findAll();
        $user = $this->getUser();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'marche'=>$marche,
            'user' => $user,
            'devise' => $devise,
            'ccc' => $ccc,
        ]);
    }

}
