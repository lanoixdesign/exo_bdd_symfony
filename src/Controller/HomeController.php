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
    Public function insertBook(EntityManagerInterface $entityManager, Request $request)
    {
        $book = new Book();

        $title = $request->query->get('title');
        $author = $request->query->get('author');
        $nbpages = $request->query->get('nbpages');
        $resume = $request->query->get('resume');

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setNbPages($nbpages);
        $book->setResume($resume);

        $entityManager->persist($book);

        $entityManager->flush();

        return new Response('livre enregistré');
    }

    /**
     * @Route("/delete/{id}", name="book_delete")
     */
    public function deleteBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id)
    {
        $book = $bookRepository->find($id);

        $entityManager->remove($book);

        $entityManager->flush();

       // return new Response('livre supprimé');
        return $this->redirectToRoute('accueil');
    }

    /**
     * @Route("/update/{id}", name="book_update")
     */
    Public function updateBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id)
    {
        $book = $bookRepository->find($id);

        $book->setTitle('titre modifié ! ');

        $entityManager->persist($book);

        $entityManager->flush();

        return new Response('le livre a bien été modifié ! ');
    }

    /**
     * @Route("/search", name="book_search")
     */
    Public function searchByResume(BookRepository $booRepository )
    {
        $books = $booRepository->getByWordInResume();

        return $this->render('search.html.twig',[
            'books'=> $books
        ]);
    }
}