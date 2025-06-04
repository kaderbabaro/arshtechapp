<?php

namespace App\Controller;

use App\Entity\Note;
use App\Repository\PartenaireRepository;
use App\Repository\TacheRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashbord', name: 'app_dashboard')]
    public function index(TransactionRepository $repo, TacheRepository $tacheRepository, PartenaireRepository $partenaireRepository,EntityManagerInterface $em): Response
    {

    $notes = $em->getRepository(Note::class)->findBy([], ['CreatedAt' => 'DESC']);


    $annee = (int) date('Y');
    $actifsTrimestriels = $repo->getTotauxTrimestrielsParType('actif', 2025);
    $passifsTrimestriels = $repo->getTotauxTrimestrielsParType('passif', 2025);

    // Initialisation à 0 pour chaque trimestre
    $actifsTrim = array_fill(1, 4, 0);
    $passifsTrim = array_fill(1, 4, 0);

foreach ($actifsTrimestriels as $row) {
    $actifsTrim[$row['trimestre']] = $row['total'];
}

foreach ($passifsTrimestriels as $row) {
    $passifsTrim[$row['trimestre']] = $row['total'];
}
         
    $stats = $tacheRepository->getTauxTachesExecuteesSemaine();
    $nombrePartenaires = $partenaireRepository->countPartenaires();
    $stats = $tacheRepository->getTauxTachesExecuteesSemaine();
    $revenusTrimestriels = $repo->getRevenusTrimestriels();
    $totalActifAnnuel = $repo->getTotalParTypeEtAnnee('Actif', $annee);
    $totalPassifAnnuel = $repo->getTotalParTypeEtAnnee('Passif', $annee);
    $soldeAnnuel = $totalActifAnnuel - $totalPassifAnnuel;

    $actifsParMois = $repo->getTotauxMensuelsParType('Actif', $annee);
    $passifsParMois = $repo->getTotauxMensuelsParType('Passif', $annee);

 // Récupération des données
        $passifs = $repo->getMontantsMensuelsParType('Passif');
        $actifs = $repo->getMontantsMensuelsParType('Actif');

        // Fusionner les données pour avoir un même axe temporel
        $labels = [];
        $dataPassifs = [];
        $dataActifs = [];


        // Pour un traitement simple, on suppose que passifs et actifs ont les mêmes périodes
        foreach ($passifs as $index => $ligne) {
            $label = $ligne['mois'] . '/' . $ligne['annee'];
            $labels[] = $label;
            $dataPassifs[] = (float) $ligne['total'];

            // Trouver montant actif correspondant, sinon 0
            $actifLigne = $actifs[$index] ?? null;
            if ($actifLigne && $actifLigne['mois'] === $ligne['mois'] && $actifLigne['annee'] === $ligne['annee']) {
                $dataActifs[] = (float) $actifLigne['total'];
            } else {
                $dataActifs[] = 0;
            }
        }

        
    return $this->render('dashboard/index.html.twig', [
        'actif_total' => $totalActifAnnuel,
        'passif_total' => $totalPassifAnnuel,
        'solde' => $soldeAnnuel,
        'actifsParMois' => $actifsParMois,
        'passifsParMois' => $passifsParMois,
        'revenusTrimestriels' => $revenusTrimestriels,
        'tauxTaches' => $stats['taux'],
        'nombrePartenaires' => $nombrePartenaires,
        'labels' => $labels,
        'dataPassifs' => $dataPassifs,
        'dataActifs' => $dataActifs,
        'actifsTrim' => $actifsTrim,
        'passifsTrim' => $passifsTrim,
        'notes' => $notes,
    ]);
    }


   #[Route('/dashboard/note/add', name: 'dashboard_note_add', methods: ['POST'])]
    public function addNote(Request $request, EntityManagerInterface $em): Response
    {
    $email = $request->request->get('message'); // CORRECT

    if ($email) {
        $note = new Note();
        $note->setMessage($email);
        $note->setCreatedAt(new \DateTimeImmutable());

        $em->persist($note);
        $em->flush();

        return $this->redirectToRoute('app_dashboard');
    }

    return new Response('Email manquant', 400);
}

#[Route('/note/{id}', name: 'app_note_delete', methods: ['POST'])]
public function delete(Request $request, Note $note, EntityManagerInterface $em): Response
{
    if ($this->isCsrfTokenValid('delete' . $note->getId(), $request->request->get('_token'))) {
        $em->remove($note);
        $em->flush();
    }

    return $this->redirectToRoute('app_dashboard');
}



}
