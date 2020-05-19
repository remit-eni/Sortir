<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function create(EntityManagerInterface $em, Request $request){

        $participant = new Participant();

        $profileForm = $this->createForm(ProfilType::class, $participant);
        $profileForm->handleRequest($request);

        if ($profileForm->isSubmitted() && $profileForm->isValid()){
            $em->persist($participant);
            $em->flush();

        }
        return $this->render('user/create.html.twig',[
            "profileForm"=>$profileForm->createView()
        ]);
    }


    /**
     * @Route("/profile/{id}/edit"), name="profile_edit")
     */
    public function edit(){
        return $this->render('user/edit.html.twig');
    }
}
