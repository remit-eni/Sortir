<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @route("/profile", name="profile_show")
     */
    public function show(){
        return $this->render('user/profile.html.twig');
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
