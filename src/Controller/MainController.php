<?php

namespace App\Controller;



use App\Form\FilterCampusType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SortieRepository $repo)
    {
        $sorties = $repo->findAll();
        $filterForm =$this->createForm(FilterCampusType::class);
        return $this->render('main/index.html.twig', [
            'filterForm' => $filterForm->createView(),
            'sorties' => $sorties
        ]);
    }
}
