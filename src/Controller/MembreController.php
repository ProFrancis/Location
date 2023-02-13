<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class MembreController extends AbstractController
{
    #[Route('/membre', name: 'app_membre')]
    public function index(Request $request, MembreRepository $repoMembre, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager): Response
    {
        $membres = $repoMembre->findAll();
        $membre = new Membre;


        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $membre, 
                $membre->getMdp()
            );
            $membre->setMdp($hashedPassword);
            $membre->setDateEnregistrement(new \DateTime());
            $manager->persist($membre);
            $manager->flush();

            $this->addFlash("success", "L'membre a bien été ajoutée");

            return $this->redirectToRoute("app_membre");
        }

        return $this->render('membre/index.html.twig', [
            'controller_name' => 'Page Membre',
            'membres' => $membres,
            'formMembre' => $form->createView()
        ]);
    }
}
