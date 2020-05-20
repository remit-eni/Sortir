<?php

namespace App\Controller;

use App\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function create(){
        return $this->render('user/create.html.twig');
    }

    /**
     * @Route("/profile/{id}/edit"), name="profile_edit")
     */
    public function edit(){
        return $this->render('user/edit.html.twig');
    }
}
