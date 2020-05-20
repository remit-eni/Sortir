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
     * @Route("/profile", name="profile_show")
     */
    public function show(){
        return $this->render('user/profile.html.twig');
    }

    /**
     * @Route("/profile/new", name="profile_create")
     */
    public function create(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $encoder){

        $participant = new Participant();
        $participant->setIsActif(true);
        $participant->setIsAdmin(true);

        $profileForm = $this->createForm(ProfilType::class, $participant);
        $profileForm->handleRequest($request);

        if ($profileForm->isSubmitted() && $profileForm->isValid()){

            $hashed = $encoder->encodePassword($participant, $participant->getPassword());
            $participant->setPassword($hashed);

            $em->persist($participant);
            $em->flush();

            return $this->redirectToRoute('login');

        }
        return $this->render('user/create.html.twig',[
            "profileForm"=>$profileForm->createView()

        ]);
    }


    /**
     * @Route("/profile/{id}/edit"), name="profile_edit", requirements={"id": "\d+"})
     */
    public function edit(){
        return $this->render('user/edit.html.twig');
    }
}
