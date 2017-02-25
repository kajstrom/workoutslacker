<?php

namespace Adapters\Web;
use Doctrine\ORM\EntityManager;
use Domain\Logging\Infrastructure\Persistence\Doctrine\ExerciseRepository;
use Domain\Logging\Infrastructure\Persistence\Doctrine\ExerciseTypeRepository;
use Domain\Logging\Infrastructure\Persistence\Doctrine\WorkoutRepository;
use Domain\Logging\Model\Exercise\Exercise;
use Domain\Logging\Model\ExerciseType\ExerciseType;
use Domain\Logging\Model\Workout\Time;
use Domain\Logging\Model\Workout\Workout;
use Domain\Logging\Model\Workout\WorkoutId;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        /** @var WorkoutRepository $workoutRepository */
        $workoutRepository = $this->entityManager->getRepository(Workout::class);

        /** @var Workout[] $workouts */
        $workouts = $workoutRepository->findAll();

        $templateWorkouts = [];
        foreach ($workouts as $workout) {
            $time = $workout->getTime();

            $templateWorkouts[] = [
                "date" => $workout->getTime()->getStart()->format("d.m.Y"),
                "id" => $workout->getId()->__toString(),
                "start" => $time->getStart()->format("H:i"),
                "end" => $time->getEnd()->format("H:i")
            ];
        }

        return new Response($this->twig->render("workout.index.html", ["workouts" => $templateWorkouts]));
    }

    public function addAction(ServerRequestInterface $serverRequestInterface) : Response
    {
        if ($serverRequestInterface->getMethod() === "POST") {
            $post = $serverRequestInterface->getParsedBody();

            $start = \DateTime::createFromFormat("d.m.Y H:i", $post["date"]. " " . $post["start"]);
            $end = \DateTime::createFromFormat("d.m.Y H:i", $post["date"]. " " . $post["end"]);

            if ($end < $start) {
                $end->add(new \DateInterval("P1D"));
            }

            $time = new Time($start, $end);

            /** @var WorkoutRepository $workoutRepository */
            $workoutRepository = $this->entityManager->getRepository(Workout::class);

            $workoutId = $workoutRepository->nextId();

            $workout = new Workout($workoutId, $time);

            $this->entityManager->persist($workout);
            $this->entityManager->flush();

            return new RedirectResponse("/workouts");
        }

        return new Response($this->twig->render("workout.add.html"));
    }

    public function showAction(ServerRequestInterface $request, $workoutId) : Response
    {
        $workoutId = new WorkoutId($workoutId);

        /** @var WorkoutRepository $workoutRepository */
        $workoutRepository = $this->entityManager->getRepository(Workout::class);
        /** @var ExerciseTypeRepository $exerciseTypeRepository */
        $exerciseTypeRepository = $this->entityManager->getRepository(ExerciseType::class);
        /** @var ExerciseRepository $exerciseRepository */
        $exerciseRepository = $this->entityManager->getRepository(Exercise::class);

        $workout = $workoutRepository->findByWorkoutId($workoutId);
        /** @var ExerciseType[] $exerciseTypes */
        $exerciseTypes = $exerciseTypeRepository->findBy([], ["name" => "ASC"]);

        $workoutExercises = $exerciseRepository->findWorkoutExercises($workoutId);

        $exerciseTypeArray = [];
        foreach ($exerciseTypes as $exerciseType) {
            $exerciseTypeArray[] = [
                "name" => $exerciseType->getName(),
                "exerciseTypeId" => $exerciseType->getExerciseTypeId()->getExerciseTypeId()
            ];
        }

        return new Response($this->twig->render("workout.show.html", [
            "date" => $workout->getTime()->getStart()->format("d.m.Y"),
            "workoutId" => $workout->getId()->__toString(),
            "exerciseTypes" => $exerciseTypeArray,
            "exercises" => $workoutExercises
        ]));
    }
}