<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Entity\Participant;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{


    /**
     * @route("/profile/new", name="profile_create")
     * @Route("/profile/{id}/edit", name="profile_edit")
     */
    public function create(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder,
                           Participant $participant = null){
       if (!$participant){
           $participant = new Participant();
       }
       $profileForm = $this->createForm(ProfilType::class, $participant);

       $profileForm->handleRequest($request);

       if ($profileForm->isSubmitted() && $profileForm->isValid()) {

           $hash = $encoder->encodePassword($participant, $participant->getPassword());
           $participant->setPassword($hash);

               if (!$participant->getId()) {
                   $participant->setIsAdmin(false);
                   $participant->setIsActif(true);
               }
           $em->persist($participant);
           $em->flush();

           return $this->redirectToRoute('profile_show', [
               'id' => $participant->getId()
           ]);
       }

           return $this->render('user/create.html.twig', [
               'profileForm'=> $profileForm->createView(),
               'editMode'=>$participant->getId()!==null
           ]);
    }

    /**
     * @Route("/profile/{id}", name="profile_show", requirements={"id": "\d+"})
     */
    public function show($id, Request $request){
        $participantRepo=$this->getDoctrine()->getRepository(Participant::class);
        $participant=$participantRepo->find($id);
        return $this->render('user/profile.html.twig',["participant"=>$participant]);
    }
}
