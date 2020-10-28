<?php

declare(strict_types=1);

namespace App\Modules\ProjectCustoms\Services;

use App\Modules\ProjectCustoms\IdealDog;
use Illuminate\Support\Str;

/**
 * Class IdealDogService
 * @package App\Modules\ProjectCustoms\Services
 */
class IdealDogService
{
    /**
     * Evaluate dog breed against the provided criteria.
     *
     * @param IdealDog $dog Dog breed to evaluate
     * @param array $criteria Keys are considered criteria names, values are values
     * @return float Average match score
     */
    public function evaluate(IdealDog $dog, array $criteria): float
    {
        return (float)collect($criteria)
            ->filter(
                function ($value, $criterion) use (&$dog) {
                    // Ignore criteria for which the dog has zero/null values
                    return !empty($dog->getAttribute($criterion));
                }
            )
            ->mapWithKeys(
                function ($value, $criterion) {
                    // Turn criteria into method names
                    // 'criterion_name' -> 'evaluateCriterionName'
                    return ['evaluate' . Str::studly($criterion) => abs(intval($value))];
                }
            )
            ->filter(
                function ($value, $method) {
                    // Ignore unsupported criteria
                    // No method available === no support for criterion
                    return method_exists($this, $method);
                }
            )
            ->map(
                function ($value, $method) use (&$dog) {
                    // Get score for each criterion
                    return round(call_user_func([$this, $method], $dog, $value), 3);
                }
            )
            ->avg();
    }

    /**
     * Check if dog qualifies for further evaluation.
     *
     * @param IdealDog $dog Dog breed to evaluate
     * @param array $criteria Keys are considered criteria names, values are values
     * @return bool True if qualifies, false if not
     */
    public function filter(IdealDog $dog, array $criteria): bool
    {
        foreach ($criteria as $criterion => $value) {
            // Every single criterion is checked by the appropriate method if implemented
            // 'criterion_name' -> 'filterCriterionName'
            $method = 'filter' . Str::studly($criterion);
            if (method_exists($this, $method) && !call_user_func([$this, $method], $dog, abs(intval($value)))) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if dog size qualifies for further evaluation
     *
     * @param IdealDog $dog
     * @param int $value
     * @return bool
     */
    private function filterSize(IdealDog $dog, int $value): bool
    {
        // 0 -> All sizes are fine
        return ($value === 0) || ($dog->size === $value);
    }

    /**
     * @param IdealDog $dog Dog breed to evaluate
     * @param int $value Value to consider
     * @return float Match score
     * @see IdealDogService::evaluate()
     */
    private function evaluateActive(IdealDog $dog, int $value): float
    {
        $difference = abs($value - (4 * ($dog->active / 5)));
        return floatval($difference < 3 ? 1 / ($difference + 1) : 0);
    }

    /**
     * @param IdealDog $dog Dog breed to evaluate
     * @param int $value Value to consider
     * @return float Match score
     * @see IdealDogService::evaluate()
     */
    private function evaluateBarking(IdealDog $dog, int $value): float
    {
        $difference = abs($value - (3 * ($dog->barking / 5)));
        return floatval(($difference < 2) ? (1 / ($difference + 1)) : 0);
    }

    /**
     * @param IdealDog $dog Dog breed to evaluate
     * @param int $value Value to consider
     * @return float Match score
     * @see IdealDogService::evaluate()
     */
    private function evaluateChildFriendly(IdealDog $dog, int $value): float
    {
        return floatval(($value === 2) ? ($dog->child_friendly * 0.2) : 1);
    }

    /**
     * @param IdealDog $dog Dog breed to evaluate
     * @param int $value Value to consider
     * @return float Match score
     * @see IdealDogService::evaluate()
     */
    private function evaluateCoatCare(IdealDog $dog, int $value): float
    {
        $difference = abs($value - (3 * ($dog->coat_care / 5)));
        return floatval(($difference < 2) ? (1 / ($difference + 1)) : 0);
    }

    /**
     * @param IdealDog $dog Dog breed to evaluate
     * @param int $value Value to consider
     * @return float Match score
     * @see IdealDogService::evaluate()
     */
    private function evaluateDribbling(IdealDog $dog, int $value): float
    {
        $difference = abs($value - (3 * ($dog->dribbling / 5)));
        return floatval(($difference < 2) ? (1 / ($difference + 1)) : 0);
    }

    /**
     * @param IdealDog $dog Dog breed to evaluate
     * @param int $value Value to consider
     * @return float Match score
     * @see IdealDogService::evaluate()
     */
    private function evaluateHome(IdealDog $dog, int $value): float
    {
        $difference = abs($value - (3 * ($dog->home / 5)));
        return floatval(($difference < 2) ? (1 / ($difference + 1)) : 0);
    }

    /**
     * @param IdealDog $dog Dog breed to evaluate
     * @param int $value Value to consider
     * @return float Match score
     * @see IdealDogService::evaluate()
     */
    private function evaluateHumanFriendly(IdealDog $dog, int $value): float
    {
        $difference = abs($value - (3 * ($dog->human_friendly / 5)));
        return floatval(($difference < 2) ? (1 / ($difference + 1)) : 0);
    }

    /**
     * @param IdealDog $dog Dog breed to evaluate
     * @param int $value Value to consider
     * @return float Match score
     * @see IdealDogService::evaluate()
     */
    private function evaluateLoneliness(IdealDog $dog, int $value): float
    {
        $difference = abs($value - (3 * ($dog->loneliness / 5)));
        return floatval(($difference < 2) ? (1 / ($difference + 1)) : 0);
    }

    /**
     * @param IdealDog $dog Dog breed to evaluate
     * @param int $value Value to consider
     * @return float Match score
     * @see IdealDogService::evaluate()
     */
    private function evaluateSocial(IdealDog $dog, int $value): float
    {
        $difference = abs($value - (3 * ($dog->social / 5)));
        return floatval(($difference < 2) ? (1 / ($difference + 1)) : 0);
    }

    /**
     * @param IdealDog $dog Dog breed to evaluate
     * @param int $value Value to consider
     * @return float Match score
     * @see IdealDogService::evaluate()
     */
    private function evaluateTrainability(IdealDog $dog, int $value): float
    {
        $difference = abs($value - (3 * ($dog->trainability / 5)));
        return floatval(($difference < 2) ? (1 / ($difference + 1)) : 0);
    }

    /**
     * @param IdealDog $dog Dog breed to evaluate
     * @param int $value Value to consider
     * @return float Match score
     * @see IdealDogService::evaluate()
     */
    private function evaluateTrainingExperience(IdealDog $dog, int $value): float
    {
        $difference = abs($value - (3 * ($dog->training_experience / 5)));
        return floatval(($difference < 2) ? (1 / ($difference + 1)) : 0);
    }
}
