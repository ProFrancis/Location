<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Entity\Commande;
use App\Entity\User;
use App\Entity\Vehicule;
use App\Repository\AgenceRepository;
use App\Repository\CommandeRepository;
use App\Repository\UserRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(Request $request,  VehiculeRepository $repoVehicule, AgenceRepository $repoAgence): Response
    {
        $vehicules = $repoVehicule->findVehiculesAndAgences();
        $agences = $repoAgence->findAll();

        if ($request->isMethod('POST')) {
            $agenceId = $request->request->get('agence');
            $vehicules = $repoVehicule->findVehiculeByIdAgences($agenceId);

            $dateLocation = \DateTime::createFromFormat('Y-m-d\TH:i', $request->request->get('dateLocation'));
            $dateFin = \DateTime::createFromFormat('Y-m-d\TH:i', $request->request->get('dateFin'));

            $interval = $dateLocation->diff($dateFin);
            $diffDays = $interval->days;

            $dateLocationStr = $dateLocation->format('Y-m-d H:i:s');
            $dateFinStr = $dateFin->format('Y-m-d H:i:s');

            return $this->render('accueil/index.html.twig', [
                'controller_name' => 'Location de vehicule',
                'filterVehicule' => true,
                'agences' => $agences,
                'dateLocation' => $dateLocationStr,
                'dateFin' => $dateFinStr,
                'nbJours' => $diffDays,
                'vehicules' => $vehicules
            ]);
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'Location de vehicule',
            'filterVehicule' => false,
            'agences' => $agences,
            'vehicules' => $vehicules,
        ]);
    }

    #[Route('/accueil/{idVehicule}/{idAgence}/{idUser}/{prix}/{dateLocation}/{dateFin}', name: 'post_commande')]
    public function add_commande($idVehicule, $idAgence, $idUser, $prix, $dateLocation, $dateFin,  VehiculeRepository $v, AgenceRepository $a, UserRepository $u, EntityManagerInterface $manager): Response
    {
        $vehicule = $v->find($idVehicule);
        $agence = $a->find($idAgence);
        $user = $u->find($idUser);

        $command = new Commande;
        $command->setIdVehicule($vehicule);
        $command->setIdAgence($agence);
        $command->setIdUser($user);
        $command->setDateHeureDepart(new \DateTime($dateLocation));
        $command->setDateHerueFin(new \DateTime($dateFin));
        $command->setPrixTotal($prix);
        $command->setDateEnregistrement(new \DateTime);

        $manager->persist($command);
        $manager->flush();

        return $this->redirectToRoute("app_accueil");
    }
}
