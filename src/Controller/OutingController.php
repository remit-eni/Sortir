<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OutingController extends AbstractController
{
    /**
     * @route("/outing", name="outing_show")
     */
    public function show(){
        return $this->render('outing/outing.html.twig');
    }

    /**
     * @route("/outing/new", name="outing_create")
     */
    public function create(){
        return $this->render('outing/create.html.twig');
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
    public function cancel(){
        return $this->render('outing/cancel.html.twig');
    }
}
