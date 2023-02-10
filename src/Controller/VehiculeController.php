<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehiculeController extends AbstractController
{
    #[Route('/vehicule', name: 'vehicule')]
    public function index(Request $request, VehiculeRepository $repoVehicule, EntityManagerInterface $manager): Response
    {
        $query = $repoVehicule->findVehiculesAndAgences();
        $vehicule = new Vehicule;

        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($vehicule);
            $manager->flush();

            $this->addFlash("success", "Le Vehicule " . $vehicule->getModele() . " a bien été ajoutée");

            return $this->redirectToRoute("vehicule");
        }

        return $this->render('vehicule/index.html.twig', [
            'controller_name' => 'page vehicule',
            'vehicules' => $query,
            'formVehicules' => $form->createView()
        ]);
    }

    #[Route('/vehicule', name: 'get_vehicule')]
    public function get(Request $request, VehiculeRepository $repoVehicule, EntityManagerInterface $manager): Response
    {
 

        return $this->render('vehicule/index.html.twig', [
            'controller_name' => 'page vehicule',
        ]);
    }

    #[Route('/vehicule', name: 'put_vehicule')]
    public function put(Request $request, VehiculeRepository $repoVehicule, EntityManagerInterface $manager): Response
    {
 

        return $this->render('vehicule/index.html.twig', [
            'controller_name' => 'page vehicule',
        ]);
    }

    #[Route('/vehicule', name: 'delete_vehicule')]
    public function delete(Request $request, VehiculeRepository $repoVehicule, EntityManagerInterface $manager): Response
    {
 

        return $this->render('vehicule/index.html.twig', [
            'controller_name' => 'page vehicule',
        ]);
    }
}
