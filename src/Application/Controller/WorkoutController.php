<?php

namespace Application\Controller;
use Doctrine\ORM\EntityManager;

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
    
    public function indexAction()
    {
        $workoutRepository = $this->entityManager->getRepository('Model\\Workout');
        $workouts = $workoutRepository->findAll();

        foreach ($workouts as $workout) {
            echo $workout->getDate()->format("d.m.Y");
        }
    }
}