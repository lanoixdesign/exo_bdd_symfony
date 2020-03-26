<?php

namespace App\Controller\admin;

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
     * @Route("admin/books/", name="admin_accueil")
     */
    public function accueil(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();

        return $this->render('admin/books/index.html.twig', [
            'books' => $books
        ]);

    }
    /**
     * @Route("admin/books/book/{id}", name="admin_book")
     */
    public function book(BookRepository $bookRepository, $id)
    {
        $book = $bookRepository->find($id);
        return $this->render('admin/books/books.html.twig', [
            'book' => $book
        ]);
    }


    /**
     * @Route("admin/books/insert", name="admin_book_insert")
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
     * @Route("admin/books/delete/{id}", name="admin_book_delete")
     */
    public function deleteBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id)
    {
        $book = $bookRepository->find($id);

        $entityManager->remove($book);

        $entityManager->flush();

       // return new Response('livre supprimé');
        return $this->redirectToRoute('admin_auteurs');
    }

    /**
     * @Route("admin/books/update/{id}", name="admin_book_update")
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
     * @Route("admin/books/search", name="admin_book_search")
     */
    Public function searchByResume(BookRepository $booRepository, Request $request)
    {
        $word = $request->query->get('word');
        $books = $booRepository->getByWordInResume($word);

        return $this->render('admin/books/search.html.twig',[
            'books' => $books,
            'word' => $word
        ]);
    }




}