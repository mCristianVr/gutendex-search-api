<?php

declare(strict_types=1);

namespace App\Books\Presentation\Controller;

use App\Books\Application\UseCase\GetBookUseCase;
use App\Books\Application\UseCase\SearchBooksUseCase;
use App\Books\Domain\Exception\BookNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class BookController extends AbstractController
{

    #[Route('/api/books', methods: ['GET'])]
    public function search(Request $request, SearchBooksUseCase $searchBooksUseCase): JsonResponse
    {
        $query = $request->query->get('search', '');

        if (strlen($query) < 2) {
            return $this->json(['error' => 'Search query must be at least 2 characters long.'], 400);
        }

        $books = $searchBooksUseCase->execute($query);

        return $this->json(array_map(
            fn($book) => [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'authors' => array_map(
                    fn($author) => [
                        'name' => $author->getName(),
                        'birth_year' => $author->getBirthYear(),
                        'death_year' => $author->getDeathYear(),
                    ],
                    $book->getAuthors()
                ),
                'subjects' => $book->getSubjects(),
            ], 
            $books
        ));
    }

    #[Route('/api/books/{id}', methods: ['GET'])]
    public function getBook(int $id, GetBookUseCase $getBookUseCase): JsonResponse
    {
        try {
            $book = $getBookUseCase->execute($id);
        } catch (BookNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], 404);
        }

        return $this->json([
            'id'        => $book->getId(),
            'title'     => $book->getTitle(),
            'authors'   => array_map(
                fn($author) => [
                    'name' => $author->getName(),
                    'birth_year' => $author->getBirthYear(),
                    'death_year' => $author->getDeathYear(),
                ],
                $book->getAuthors()
            ),
            'subjects' => $book->getSubjects(),
        ]);
    }

}
