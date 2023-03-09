<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Form\AgenceType;
use App\Repository\AgenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgenceController extends AbstractController
{
    #[Route('/admin/agence', name: 'agence')]
    public function index(Request $request, AgenceRepository $repoAgence, EntityManagerInterface $manager): Response
    {
        $agence = new Agence;
        $agences = $repoAgence->findAll();

        $form = $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($agence);
            $manager->flush();

            $this->addFlash("success", "L'agence" . $agence->getTitre() . " a bien été ajoutée");

            return $this->redirectToRoute("agence");
        }
        return $this->render('agence/index.html.twig', [
            'controller_name' => 'Page Agence',
            'agences' => $agences,
            'formAgence' => $form->createView()
        ]);
    }

    #[Route('/admin/agence/detail/{id}', name: 'detail_agence')]
    public function detail($id, AgenceRepository $repoAgence): Response
    {

        $getAgenceById = $repoAgence->find($id);

        return $this->render('agence/detail.html.twig', [
            'controller_name' => 'Detail Agence',
            'agence' => $getAgenceById,

        ]);
    }

    #[Route('/admin/agence/update/{id}', name: 'update_agence')]
    public function add(Agence $agence, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($agence);
            $manager->flush();

            $this->addFlash("success", "L'agence " . $agence->getTitre() . " a bien été modifiée.");
            return $this->redirectToRoute("agence");
        }

        return $this->render('agence/update.html.twig', [
            'controller_name' => 'Update Agence',
            'formAgence' => $form->createView(),
            'agence' => $agence
        ]);
    }

    #[Route('/admin/agence/supprimer/{id}', name: 'delete_agence')]
    public function delete(Agence $agence, EntityManagerInterface $manager): Response
    {
        $idAgence = $agence->getId();

        $manager->remove($agence);
        $manager->flush();

        $this->addFlash("success", "L'Agence N° " . $idAgence . " a bien été supprimée.");
        return $this->redirectToRoute("agence");
    }
}
