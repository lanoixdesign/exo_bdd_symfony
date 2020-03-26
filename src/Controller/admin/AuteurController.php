<?php

namespace App\Controller\admin;

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
     * @Route("admin/auteurs", name="admin_auteurs")
     */
    Public function auteur(AuteurRepository $auteurRepository)
    {
        $auteurs = $auteurRepository->findAll();

        return $this->render('admin/auteurs/auteurs.html.twig',[
            'auteurs' => $auteurs
            ]);

    }

    /**
     * @Route("admin/auteurs/insert", name="admin_insert_auteur")
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

        return $this->render('admin/auteurs/insert_auteur.html.twig',[
            'author'=> $auteur
        ]);

    }

    /**
     * @Route("admin/auteurs/delete/{id}", name="admin_delete_auteur")
     */
    public function updateAuteur(AuteurRepository $auteurRepository, EntityManagerInterface $entityManager, $id)
    {
        $auteur = $auteurRepository->find($id);
        $entityManager->remove($auteur);
        $entityManager->flush();

        return $this->redirectToRoute('admin_accueil');

    }

    /**
     * @Route("admin/auteurs/search", name="admin_search_auteur")
     */
    public function searchByName(AuteurRepository $auteurRepository, Request $request)
    {
        $wordname =$request->query->get('wordname');
        $auteurs = $auteurRepository->getByAuteurInLibrary($wordname);

        return $this->render('admin/auteurs/search_auteur.html.twig',[
            'auteurs'=> $auteurs,
            'wordname' => $wordname
        ]);
    }

    /**
     * @Route("admin/auteurs/show/{id}", name="admin_show_auteur")
     */
    Public function showAuteur(AuteurRepository $auteurRepository, $id)
    {
        $auteur = $auteurRepository->find($id);

        return $this->render('admin/auteurs/show_auteur.html.twig',['auteur' => $auteur]);

    }



}