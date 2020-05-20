<?php

namespace App\Controller;

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
     * @Route("/profile/{id}", name="profile_show", requirements={"id": "\d+"})
     */
    public function show($id, Request $request){
        $participantRepo=$this->getDoctrine()->getRepository(Participant::class);
        $participant=$participantRepo->find($id);
        return $this->render('user/profile.html.twig',["participant"=>$participant]);
    }

    /**
     * @route("/profile/new", name="profile_create")
     */
    public function create(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder){
        $participant = new Participant();
        $participant->setIsAdmin(false);
        $participant->setIsActif(true);

        $profileForm = $this->createForm(ProfilType::class, $participant);

        $profileForm->handleRequest($request);
        if($profileForm ->isSubmitted() && $profileForm ->isValid()){
            $hash = $encoder->encodePassword($participant, $participant->getPassword());
            $participant->setPassword($hash);
            $em->persist($participant);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('user/create.html.twig', [
            'profileForm' => $profileForm->createView()
        ]);
    }

    /**
     * @Route("/profile/{id}/edit"), name="profile_edit")
     */
    public function edit(){
        return $this->render('user/edit.html.twig');
    }
}
