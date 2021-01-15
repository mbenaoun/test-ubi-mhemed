<?php

namespace App\Controller;

use App\Service\NotationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AvgNotationsUserController.
 */
class AvgNotationsUserController extends AbstractController
{
    /** @var NotationService */
    private NotationService $notationService;

    /**
     * AvgNotationsUserController constructor.
     *
     * @param NotationService $notationService
     */
    public function __construct(NotationService $notationService)
    {
        $this->notationService = $notationService;
    }

    /**
     * @Route(
     *     name="users_avg",
     *     path="/users/{userId}/avg",
     *     methods={"GET"},
     *     requirements={"userId": "\d+"}
     * )
     *
     * @param int $userId
     *
     * @return JsonResponse
     */
    public function __invoke(int $userId): JsonResponse
    {
        return new JsonResponse($this->notationService->getAvgUser($userId));
    }
}
