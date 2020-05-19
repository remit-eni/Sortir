<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @route("/registration", name="security_registration")
     */
    public function registration()
    {
        return $this->render('security/registration.html.twig');
    }


    /**
     * @route("/login", name="security_login")
     */
    public function login() {
        return $this->render('security/login.html.twig');
    }

    /**
     * @route("/logout", name="security_logout")
     */
    public function logout()
    {
        return $this->render('security/logout.html.twig');
    }
}
