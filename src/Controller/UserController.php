<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @route("/profile/new", name="profile_create")
     * @Route("/profile/{id}/edit", name="profile_edit")
     */
    public function create(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder,
                           Participant $participant = null, AuthenticationUtils $authenticationUtils):Response
    {

        if (!$participant)
        {
            $participant = new Participant();
        }

        $profileForm = $this->createForm(ProfilType::class, $participant);

        $profileForm->handleRequest($request);

        if ($profileForm->isSubmitted() && $profileForm->isValid()) {

            $clearPassword = $participant->getPassword();
            $hash = $encoder->encodePassword($participant, $participant->getPassword());
            $participant->setPassword($hash);

            if (!$participant->getId())
            {
                $participant->setIsAdmin(false);
                $participant->setIsActif(true);

                $em->persist($participant);
                $em->flush();

                $error = $authenticationUtils->getLastAuthenticationError();
                $lastUsername = $authenticationUtils->getLastUsername();

                $this->addFlash('success', 'Votre profil a bien été enregistré !');
                return $this->render('security/login.html.twig', ['username' => $participant->getUsername(), 'clearPassword' => $clearPassword, 'last_username' => $lastUsername, 'error' => $error]);
            } else {

                    $em->persist($participant);
                    $em->flush();

                    $this->addFlash('success', 'Votre profil a bien été modifié !');
                    return $this->redirectToRoute('home', [
                        'id' => $participant->getId()
                    ]);
                    }
        }

        return $this->render('user/create.html.twig', [
            'profileForm' => $profileForm->createView(),
            'editMode' => $participant->getId() !== null
        ]);
    }

    /**
     * @Route("/profile/{id}", name="profile_show", requirements={"id": "\d+"})
     */
    public function show($id, Request $request)
    {
        $participantRepo = $this->getDoctrine()->getRepository(Participant::class);
        $participant = $participantRepo->find($id);
        return $this->render('user/profile.html.twig', ["participant" => $participant]);
    }
}
