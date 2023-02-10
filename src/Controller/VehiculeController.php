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
            'controller_name' => 'Vehicule',
            'vehicules' => $query,
            'formVehicules' => $form->createView()
        ]);
    }

    #[Route('/get/vehicule/{id}', name: 'get_vehicule')]
    public function get($id, VehiculeRepository $repoVehicule): Response
    {

        $getVehiculeById = $repoVehicule->find($id);

        return $this->render('vehicule/detail.html.twig', [
            'controller_name' => 'Vehicule',
            'vehicule' => $getVehiculeById,

        ]);
    }

    #[Route('/put/vehicule/{id}', name: 'put_vehicule')]
    public function put(Request $request, Vehicule $vehicule, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($vehicule);
            $manager->flush();

            $this->addFlash("success", "Le Vehicule " . $vehicule->getTitre() . " a bien été modifiée.");
            return $this->redirectToRoute("vehicule");
        }

        return $this->render('vehicule/update.html.twig', [
            'controller_name' => 'Update Vehicule',
            'formVehicule' => $form->createView(),
            'vehicule' => $vehicule
        ]);
    }

    #[Route('/delete/vehicule/{id}', name: 'delete_vehicule')]
    public function delete(Vehicule $vehicule, EntityManagerInterface $manager): Response
    {
        $idVehicule = $vehicule->getId();

        $manager->remove($vehicule);
        $manager->flush();

        $this->addFlash("success", "Le Vehicule N° " . $idVehicule . " a bien été supprimée.");
        return $this->redirectToRoute("vehicule");
    }
}
