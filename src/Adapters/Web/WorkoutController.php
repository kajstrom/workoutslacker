<?php

namespace Adapters\Web;
use Application\WorkoutService;
use Domain\Logging\Model\Workout\Workout;
use Domain\Logging\Model\Workout\WorkoutId;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController
{
    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var WorkoutService
     */
    private $workoutService;

    public function __construct(\Twig_Environment $twig, WorkoutService $workoutService)
    {
        $this->twig = $twig;
        $this->workoutService = $workoutService;
    }
    
    public function indexAction(ServerRequestInterface $serverRequestInterface) : Response
    {
        $workouts = $this->workoutService->all();

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

            $this->workoutService->add($start, $end);

            return new RedirectResponse("/workouts");
        }

        return new Response($this->twig->render("workout.add.html"));
    }

    public function showAction(ServerRequestInterface $request, $workoutId) : Response
    {
        $workoutId = new WorkoutId($workoutId);

        $workoutInformation = $this->workoutService->show($workoutId);

        /** @var Workout $workout */
        $workout = $workoutInformation["workout"];
        $exercises = $workoutInformation["exercises"];
        $exerciseTypes = $workoutInformation["exerciseTypes"];

        return new Response($this->twig->render("workout.show.html", [
            "date" => $workout->getTime()->getStart()->format("d.m.Y"),
            "workoutId" => $workout->getId()->__toString(),
            "exerciseTypes" => $exerciseTypes,
            "exercises" => $exercises
        ]));
    }
}