<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    /**
     * @Route("/", name="accueil")
     */
    public function accueil(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();

        return $this->render('index.html.twig', [
            'books' => $books
        ]);

    }
    /**
     * @Route("/book/{id}", name="book")
     */
    public function book(BookRepository $bookRepository, $id)
    {
        $book = $bookRepository->find($id);
        return $this->render('books.html.twig', [
            'book' => $book
        ]);
    }


    /**
     * @Route("/insert", name="book_insert")
     */
    Public function insertBook(EntityManagerInterface $entityManager)
    {
        $book =new Book();

        $book->setTitle('titre depuis le controleur');
        $book->setAuthor('JPP');
        $book->setNbpages(200);
        $book->setResume('teqkjsbdkueh au qhskdjaz  d azhdk adzi');

        $entityManager->persist($book);

        $entityManager->flush();

        return new Response('livre enregistré');
    }





}