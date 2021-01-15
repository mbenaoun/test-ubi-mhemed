<?php

namespace App\Controller;

use App\Service\NotationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AvgNotationsUsersController
 * @package App\Controller
 */
class AvgNotationsUsersController extends AbstractController
{
    /** @var NotationService */
    private NotationService $notationService;

    /**
     * AvgNotationsUsersController constructor.
     * @param NotationService $notationService
     */
    public function __construct(NotationService $notationService)
    {
        $this->notationService = $notationService;
    }

    /**
     * @Route(
     *     name="notations_avg",
     *     path="/notations/avg",
     *     methods={"GET"}
     * )
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->notationService->getAvgUsers());
    }
}