<?php

namespace Application\Controller;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: Kaitsu
 * Date: 28.3.2016
 * Time: 22:45
 */
class WorkoutController
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function indexAction(Request $request) : Response
    {
        $workoutRepository = $this->entityManager->getRepository('Model\\Workout');
        $workouts = $workoutRepository->findAll();

        $response = "";
        foreach ($workouts as $workout) {
            $response .= $workout->getDate()->format("d.m.Y");
        }

        return new Response($response);
    }
}