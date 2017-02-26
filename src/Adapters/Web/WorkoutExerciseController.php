<?php
/**
 * Created by PhpStorm.
 * User: Kaitsu
 * Date: 25.2.2017
 * Time: 10:50
 */

namespace Adapters\Web;


use Doctrine\ORM\EntityManager;
use Domain\Logging\Infrastructure\Persistence\Doctrine\ExerciseRepository;
use Domain\Logging\Model\Exercise\Exercise;
use Domain\Logging\Model\ExerciseType\ExerciseTypeId;
use Domain\Logging\Model\Workout\WorkoutId;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class WorkoutExerciseController
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

    public function addAction(ServerRequestInterface $request, string $workoutId) : Response
    {
        /** @var ExerciseRepository $exerciseRepository */
        $exerciseRepository = $this->entityManager->getRepository(Exercise::class);

        $workoutId = new WorkoutId($workoutId);

        $post = $request->getParsedBody();

        $exerciseTypeId = new ExerciseTypeId($post["exerciseTypeId"]);
        $exerciseId = $exerciseRepository->nextId();
        $nthExerciseInWorkout = $exerciseRepository->exerciseCountForWorkout($workoutId) + 1;

        $exercise = new Exercise($exerciseId, $workoutId, $exerciseTypeId, $nthExerciseInWorkout);

        $this->entityManager->persist($exercise);
        $this->entityManager->flush();

        return new RedirectResponse("/workouts/show/$workoutId");
    }
}