<?php

namespace App\Controller\Back;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Security\BookVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;

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
        $this->get('session')->set('_locale', 'fr');

        return $this->render('back/book/index.html.twig', [
            'books' => $bookRepository->findBy([], ['position' => 'ASC'])
        ]);
    }

    /**
     * @Route("/search/{q}", name="search", methods={"GET"})
     */
    public function search($q, BookRepository $bookRepository)
    {
        return $this->render('back/book/search.html.twig', [
            'books' => $bookRepository->search($q, true)
        ]);
    }

    /**
     * @Route("/show/{slug}", name="show", methods={"GET"})
     *
     * Call Book with ParamConverter
     */
    public function show(Book $book)
    {
        return $this->render('back/book/show.html.twig', [
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

            $this->addFlash('green', 'Création effectuée');

            return $this->redirectToRoute('admin_book_show', [
                'slug' => $book->getSlug()
            ]);
        }

        return $this->render('back/book/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"GET", "POST"})
     * @IsGranted(BookVoter::EDIT, subject="book")
     */
    public function edit(Book $book, Request $request)
    {
        //$this->denyAccessUnlessGranted(BookVoter::EDIT, $book);

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('green', 'Modification effectuée');

            return $this->redirectToRoute('admin_book_edit', [
                'id' => $book->getId()
            ]);
        }

        return $this->render('back/book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }

    /**
     * @Route("/delete/{id}/{token}", name="delete", methods={"GET"})
     */
    public function delete(Book $book, $token)
    {
        $this->denyAccessUnlessGranted(BookVoter::DELETE, $book);

        if (!$this->isCsrfTokenValid('delete_book' . $book->getName(), $token)) {
            throw new Exception('Invalid CSRF Token');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();

        $this->addFlash('green', 'Suppression effectuée');

        return $this->redirectToRoute('admin_book_index');
    }

    /**
     * @Route("/sortable/{slug}/{sortable}", name="sortable", methods={"GET"}, requirements={"sortable"="up|down"})
     */
    public function sortable(Book $book, $sortable)
    {
        $em = $this->getDoctrine()->getManager();
        $book->setPosition($sortable === 'up' ? $book->getPosition()+1 :$book->getPosition()-1);
        $em->flush();

        return $this->redirectToRoute('admin_book_index');
    }
}
