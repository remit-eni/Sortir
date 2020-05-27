<?php

namespace App\Controller;



use App\Entity\Sortie;
use App\Entity\SortiesSearch;
use App\Form\SortiesSearchType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, SortieRepository $repo, EntityManagerInterface $em): Response
    {
        $sortiesSearch = new SortiesSearch();

        $filterForm = $this->createForm(SortiesSearchType::class, $sortiesSearch);
        $filterForm->handleRequest($request);

        $repo = $this->getDoctrine()->getRepository(Sortie::class);

        $sorties = $repo->findAllSorties($sortiesSearch);


        return $this->render('main/index.html.twig',[
            'filterForm' => $filterForm->createView(),
            'sorties' => $sorties
        ]);
    }
}
