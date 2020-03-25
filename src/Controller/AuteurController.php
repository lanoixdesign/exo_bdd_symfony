<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuteurController extends AbstractController
{
    /**
     * @Route("auteurs", name="auteurs")
     */
    Public function auteur(AuteurRepository $auteurRepository)
    {
        $auteurs = $auteurRepository->findAll();

        return $this->render('auteurs.html.twig',[
            'auteurs' => $auteurs
            ]);

    }

    /**
     * @Route("auteurs/insert", name="insert_auteur")
     */
    public function insertAuteur(Request $request,EntityManagerInterface $entityManager)
    {
        $auteur = new Auteur();

        $name = $request->query->get('name');
        $firstname = $request->query->get('firstName');
        $birthdate = $request->query->get('birthDate');
        $deathdate = $request->query->get('deathDate');
        $biography = $request->query->get('biography');

        $auteur->setName($name);
        $auteur->setFirstName($firstname);
        $auteur->setBirthDate($birthdate);
        $auteur->setDeathDate($deathdate);
        $auteur->getBiography($biography);

        $entityManager->persist($auteur);

        $entityManager->flush();

        return new Response('livre enregistré');

    }

    /**
     * @Route("auteurs/delete/{id}", name="delete_auteur")
     */
    public function updateAuteur(AuteurRepository $auteurRepository, EntityManagerInterface $entityManager, $id)
    {
        $auteur = $auteurRepository->find($id);
        $entityManager->remove($auteur);
        $entityManager->flush();

        return $this->redirectToRoute('accueil');

    }





}