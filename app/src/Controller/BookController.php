<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BookController
 * @package App\Controller
 *
 * @Route("/books", name="book_")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     *
     * Call BookRepository with Autowiring
     */
    public function index(BookRepository $bookRepository)
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show", methods={"GET"})
     *
     * Call Book with ParamConverter
     */
    public function show(Book $book)
    {
        return $this->render('book/show.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('book_show', [
                'id' => $book->getId()
            ]);
        }

        return $this->render('book/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"GET", "POST"})
     */
    public function edit(Book $book, Request $request)
    {
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('book_edit', [
                'id' => $book->getId()
            ]);
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }
}
