<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MarcheRepository;
use App\Repository\DeviseRepository;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

use App\Entity\Cours;
use App\Entity\Marche;
use App\Form\CoursType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



use Dompdf\Dompdf;
use Dompdf\Options;




class MarcheController extends AbstractController
{
    #[Route('/marche', name: 'app_marche')]
    public function index(MarcheRepository $MRepo,DeviseRepository $DevRepo ,CoursRepository $Crepo, Security $security): Response
    {   
        $ccc=$Crepo->findAll();
        $marche=$MRepo->findAll();
        $devise=$DevRepo->findAll();
        $user = $this->getUser();
        if ($security->isGranted('ROLE_ADMIN')) {

            return $this->render('admin/dashboard.html.twig',[
                'controller_name' => 'MarcheController',
                'marche'=>$marche,
                'user' => $user,
                'devise' => $devise,
                'ccc' => $ccc
            ]);

        }
        return $this->render('marche/index.html.twig', [
            'controller_name' => 'MarcheController',
            'marche'=>$marche,
            'user' => $user,
            'devise' => $devise,
            'ccc' => $ccc
        ]);
    }

    #[Route('/{id}/marche', name: 'app_cours_by_marche')]
    public function index_marches(Marche $marche,MarcheRepository $MRepo,DeviseRepository $DevRepo ,CoursRepository $Crepo): Response
    {
        $ccc=$marche->getCours();
        $marche=$MRepo->findAll();
        $devise=$DevRepo->findAll();
        $user = $this->getUser();
        return $this->render('marche/index.html.twig', [
            'controller_name' => 'MarcheController',
            'marche'=>$marche,
            'user' => $user,
            'devise' => $devise,
            'ccc' => $ccc,
        ]);
    }


    #[Route('/menu', name: 'app_menu')]
    public function menu(MarcheRepository $MRepo,DeviseRepository $DevRepo,CoursRepository $Crepo): Response
    {
        $ccc=$Crepo->findAll();
        $marche=$MRepo->findAll();
        $devise=$DevRepo->findAll();
        $user = $this->getUser();

        return $this->render('marche/menu.html.twig', [
            'controller_name' => 'MarcheController',
            'marche'=>$marche,
            'user' => $user,
            'devise' => $devise,
            'ccc' => $ccc

        ]);
    }
//pdf
    /**
     * @Route ("{id}/pdf" ,name="app_pdf")
     */
    public function pdf(Marche $marche,MarcheRepository $MRepo,DeviseRepository $DevRepo ,CoursRepository $Crepo)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $ccc=$marche->getCours();
        $march=$MRepo->findAll();
        $html = $this->renderView('pdf_generator/index.html.twig',
            ['ccc' => $ccc,
                'marche'=> $marche,
            ]);
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');


        // Render the HTML as PDF
        $dompdf->render();
        $pdfFilePath = 'C:\Users\khali\OneDrive\Bureau\pp.pdf';
        file_put_contents($pdfFilePath, $dompdf->output());
        $response = new Response(file_get_contents($pdfFilePath));
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="document.pdf"');
        return $response;
    }
}
