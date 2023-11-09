<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonneController extends AbstractController
{
    public function __construct(
        private PersonneRepository $personneRepo,
        private EntityManagerInterface $em,
    ) {
    }

    #[Route('/', name: 'app_personne')]   // Affiche la liste des personnes dans une grille
    public function index(): Response
    {
        $personnes = $this->personneRepo->findAll();
        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
        ]);
    }

    #[Route('/personne/create', name: 'personne_create')]    // permet d'jouter une nouvelle personne
    public function create(Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($personne);
            $this->em->flush();
            return $this->redirectToRoute('app_personne');
        }

        return $this->render('personne/formPersonne.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/personne/{id}/edit', name: 'personne_edit')]    // permet de modifier les données d'une personne
    public function edit(Request $request, int $id): Response
    {
        $personne = $this->personneRepo->find($id);
        $form = $this->createForm(PersonneType::class, $personne);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $this->em->flush();
            return $this->redirectToRoute('app_personne');
        }

        return $this->render('personne/formPersonne.html.twig', [
            'form' => $form,
            'personne' => $personne,
        ]);
    }

    #[Route('/personne/{id}/delete', name: 'personne_delete')]   // Permet de supprimer une personne de la grille
    public function delete(int $id): Response
    {
        $personne = $this->personneRepo->find($id);
        $this->em->remove($personne);
        $this->em->flush();
        return $this->redirectToRoute('app_personne');
    }
}
