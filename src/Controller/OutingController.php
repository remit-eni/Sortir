<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\OutingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OutingController extends AbstractController
{
    /**
     * @route("/outing/{id}", name="outing_show", requirements={"id": "\d+"} )
     */
    public function show($id, Request $request){

        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        return $this->render('outing/show.html.twig', ["sortie"=>$sortie]);
    }

    /**
     * @Route("/outing/new", name="outing_create")
     */
    public function create(EntityManagerInterface $em, Request $request){

        $sortie = new Sortie();

        $outingForm = $this->createForm(OutingType::class, $sortie);
        $sortieEtatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $outingForm->handleRequest($request);

        if ($outingForm->isSubmitted() && $outingForm->isValid()){

            //Modification de l'état
            $etatCreee = $sortieEtatRepo->findOneBy(['libelle' =>'Créée']);
            $sortie->setEtat($etatCreee);

            //Nom de l'organisateur
            $sortie->setOrganisateur($this->getUser());


            $em->persist($sortie);
            $em->flush();


        }
        return $this->render('outing/create.html.twig',[
            "outingForm"=>$outingForm->createView()
        ]);
    }

    /**
     * @Route("/outing/{id}/edit"), name="outing_edit")
     */
    public function edit(){
        return $this->render('outing/edit.html.twig');
    }

    /**
     * @Route("/outing/{id}/cancel"), name="outing_cancel")
     */
    public function cancel(Sortie $sortie, EntityManagerInterface $em, Request $request){

        $participant = $this->getUser();

        $outingCancelForm = $this->createForm(OutingCancelType::class, $sortie);
        $sortieEtatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $outingCancelForm->handleRequest($request);

        if($outingCancelForm->isSubmitted() && $outingCancelForm->isValid()){

            $sortie->setInfosSortie($outingCancelForm['infosSortie']->getData());
            $etatAnnule = $sortieEtatRepo->findOneBy(['libelle' =>'Annulée']);
            $sortie->setEtat($etatAnnule);

            $em->flush();
            $this->addFlash('success', 'La sortie a été annulée !');

            $this->sortiesListe = $em->getRepository(Sortie::class)->findAll();

            return $this->redirectToRoute('login');

        }



        return $this->render('outing/cancel.html.twig', [
            'page_name' => 'Annuler Sortie',
            'sortie' => $sortie,
            'participants' => $participant,
            'outingCancelForm' => $outingCancelForm->createView()
        ]);
    }


}
