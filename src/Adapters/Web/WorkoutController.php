<?php

namespace Adapters\Web;
use Doctrine\ORM\EntityManager;
use Domain\WorkoutLog\Workout;
use Psr\Http\Message\ServerRequestInterface;
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
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Twig_Environment $twig, EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }
    
    public function indexAction(ServerRequestInterface $serverRequestInterface) : Response
    {
        $workoutRepository = $this->entityManager->getRepository(Workout::class);
        $workouts = $workoutRepository->findAll();

        $templateWorkouts = [];
        foreach ($workouts as $workout) {
            $templateWorkouts[] = [
                "date" => $workout->getDate()->format("d.m.Y")
            ];
        }

        return new Response($this->twig->render("workout.index.html", ["workouts" => $templateWorkouts]));
    }
}