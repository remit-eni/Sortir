<?php

namespace App\Controller;



use App\Entity\Inscription;
use App\Entity\Sortie;
use App\Entity\SortiesSearch;
use App\Form\SortiesSearchType;
use App\Repository\InscriptionRepository;
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
    public function index(Request $request, SortieRepository $repo, InscriptionRepository $repoS, EntityManagerInterface $em): Response
    {
        $sortiesSearch = new SortiesSearch();

        $filterForm = $this->createForm(SortiesSearchType::class, $sortiesSearch);
        $filterForm->handleRequest($request);

        $repo = $this->getDoctrine()->getRepository(Sortie::class);

        $sorties = $repo->findAllSorties($sortiesSearch);
        $inscriptions = $repoS->findAll();

        return $this->render('main/index.html.twig',[
            'filterForm' => $filterForm->createView(),
            'sorties' => $sorties,
            'inscriptions' => $inscriptions
        ]);
    }

    /**
     * @Route("/subscribe/{id}", name="subscribe", requirements={"id": "\d+"})
     */
    public function inscription( $id, EntityManagerInterface $em, Request $request )
    {
        $inscription = new Inscription();

        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);
        $participant = $this->getUser();

        //$date = new \DateTime();
        //dump($date);

        //Contrainte => Ne peut pas s'inscrire 2 fois à la même sortie
        /*if($this->date > $sortie->getDateLimiteInscription()){
            $this->addFlash("danger", "Impossible de vous inscrire car la dâte de clôture des inscriptions est dépassée !" );
            return $this->redirectToRoute('outing_show',['id'=>$sortie->getId()]);
        }*/


        //Contrainte => Date de clôture inscription dépassée
        /*if($this->date > $sortie->getDateLimiteInscription()){
            $this->addFlash("danger", "Impossible de vous inscrire car la dâte de clôture des inscriptions est dépassée !" );
            return $this->redirectToRoute('outing_show',['id'=>$sortie->getId()]);
        }*/

        //Contrainte => NB de places maximales atteintes
       /*if($sortie->getParticipants() >= $sortie->getNbInscriptionsMax()){
            $this->addFlash("danger", "Impossible de vous inscrire car il n'y plus de places disponibles ! ");
            return $this->redirectToRoute('outing_show',['id'=>$sortie->getId()]);
        }*/

        $inscription->setParticipant($participant);
        $inscription->setSortie($sortie);

        $em->persist($inscription);
        $em->flush();

        $this->addFlash('success', 'Votre inscription a bien été enregistré !');
        return $this->redirectToRoute('outing_show',[
            'id'=>$sortie->getId()
        ]);
    }

    /**
     * @Route("/subscribe/{id}/cancel", name="cancel_subscribe", requirements={"id": "\d+"})
     */
    public function desistement($id, EntityManagerInterface $em)
    {
        $inscription = $this->getDoctrine()->getRepository(Inscription::class)->findOneBy(['id' => $id]);

        /*if($inscription->getParticipant() != $this->getUser()){
            $this->addFlash("success", "Impossible de se désister, vous n'êtes pas encore inscrit !");
            return $this->redirectToRoute('outing_show',[
                'id'=>$inscription->getSortie()->getId()
            ]);
        }*/

        $em->remove($inscription);
        $em->flush();

        $this->addFlash('success', 'Votre désistement a bien été enregistré !');
        return $this->redirectToRoute('outing_show',[
            'id'=>$inscription->getSortie()->getId()
        ]);
    }


}
