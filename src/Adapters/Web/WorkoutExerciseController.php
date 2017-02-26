<?php
/**
 * Created by PhpStorm.
 * User: Kaitsu
 * Date: 25.2.2017
 * Time: 10:50
 */

namespace Adapters\Web;


use Application\WorkoutExerciseService;
use Doctrine\ORM\EntityManager;
use Adapters\Persistence\Doctrine\Logging\ExerciseRepository;
use Domain\Logging\Model\Exercise\Exercise;
use Domain\Logging\Model\ExerciseType\ExerciseTypeId;
use Domain\Logging\Model\Workout\WorkoutId;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class WorkoutExerciseController
{
    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var WorkoutExerciseService
     */
    private $workoutExerciseService;

    public function __construct(\Twig_Environment $twig, WorkoutExerciseService $workoutExerciseService)
    {
        $this->twig = $twig;
        $this->workoutExerciseService = $workoutExerciseService;
    }

    public function addAction(ServerRequestInterface $request, string $workoutId) : Response
    {
        $workoutId = new WorkoutId($workoutId);

        $post = $request->getParsedBody();

        $exerciseTypeId = new ExerciseTypeId($post["exerciseTypeId"]);

        $this->workoutExerciseService->add($workoutId, $exerciseTypeId);

        return new RedirectResponse("/workouts/show/$workoutId");
    }
}