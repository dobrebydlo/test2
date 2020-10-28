<?php

declare(strict_types=1);

namespace App\Modules\ProjectCustoms\Repositories;

use App\Modules\ProjectCustoms\IdealDog;
use App\Modules\ProjectCustoms\Services\IdealDogService;

/**
 * Class IdealDogRepository
 * @package App\Modules\ProjectCustoms\Repositories
 */
class IdealDogRepository
{
    /**
     * Minimum match score (between 0 and 1) to make it to the list of matching breeds.
     * Define projectcustoms.idealDog.matchThreshold in config to override this value.
     */
    public const DEFAULT_MATCH_THRESHOLD = 0.1;

    /**
     * Maximum number of matched breeds on the list. 0 for unlimited.
     * Define projectcustoms.idealDog.matchCount in config to override this value.
     */
    public const DEFAULT_MATCH_COUNT = 0;

    /**
     * @var IdealDogService
     */
    private $idealDogService;

    /**
     * IdealDogRepository constructor.
     * @param IdealDogService $idealDogService
     */
    public function __construct(IdealDogService $idealDogService)
    {
        $this->idealDogService = $idealDogService;
    }

    /**
     * Get the list of dog breeds matching the provided criteria.
     * Each of the returned IdealDog instances has its 'match' property set to value
     * between 0 and 1 (float) indicating how closely the breed matches the criteria.
     *
     * @param array $criteria Keys are considered criteria names, values are values
     * @return IdealDog[] The list of matching breeds sorted by match score descending
     */
    public function getMatching(array $criteria): array
    {
        $idealDogService = $this->idealDogService;
        $matchThreshold = $this->getMatchThreshold();

        return IdealDog::all()
            ->filter(
                function (IdealDog $dog) use (&$criteria, &$idealDogService) {
                    // Check if dog even qualifies before evaluating
                    return $idealDogService->filter($dog, $criteria);
                }
            )
            ->map(
                function (IdealDog $dog) use (&$criteria, &$idealDogService) {
                    $dog->match = $idealDogService->evaluate($dog, $criteria);
                    return $dog;
                }
            )
            ->filter(
                function (IdealDog $dog) use (&$matchThreshold) {
                    return $dog->match >= $matchThreshold;
                }
            )
            ->sortByDesc('match')
            ->take($this->getMatchCount() ?: null)
            ->values()
            ->toArray();
    }

    /**
     * Get maximum number of breeds on list.
     *
     * @return int
     */
    private function getMatchCount(): int
    {
        return intval(config('projectcustoms.idealDog.matchCount', self::DEFAULT_MATCH_COUNT));
    }

    /**
     * Get minimum match score (between 0 and 1) to make it to the list.
     *
     * @return float
     */
    private function getMatchThreshold(): float
    {
        return floatval(config('projectcustoms.idealDog.matchThreshold', self::DEFAULT_MATCH_THRESHOLD));
    }
}
