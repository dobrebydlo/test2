<?php

namespace App\Modules\ProjectCustoms;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * Class IdealDog
 * @package App\Modules\ProjectCustoms
 * @property float $match Indicates how closely this particular breed matches the criteria when evaluating
 * @property int $id
 * @property string $name
 * @property int $size
 * @property string $size_exact
 * @property string $weight_exact
 * @property int $playfulness
 * @property int $energy
 * @property int $movement_intensity
 * @property int $active
 * @property int $coat_care
 * @property int $dribbling
 * @property int $moulting
 * @property int $devotion
 * @property int $human_friendly
 * @property int $social
 * @property int $small_animals_friendly
 * @property int $child_friendly
 * @property int $trainability
 * @property string $lifetime_exact
 * @property int $training_experience
 * @property int $home
 * @property int $barking
 * @property int $loneliness
 * @property int $hunting_instinct
 */
class IdealDog extends Model {
    /**
     * This property is defined explicitly to prevent putting it into the database when calling ->save() on Model.
     * @var float Indicates how closely this particular breed matches the criteria when evaluating.
     * @see IdealDog::getMatchAttribute()
     * @see IdealDog::setMatchAttribute()
     */
    private $match = 1.0;

    public $timestamps = FALSE;
    protected $table = 'dogs';
	protected $fillable = [
        'name',
        'size',
        'size_exact',
        'weight_exact',
        'playfulness',
        'energy',
        'movement_intensity',
        'active',
        'coat_care',
        'dribbling',
        'moulting',
        'devotion',
        'human_friendly',
        'social',
        'small_animals_friendly',
        'child_friendly',
        'trainability',
        'lifetime_exact',
        'training_experience',
        'home',
        'barking ',
        'loneliness',
        'hunting_instinct',
    ];

	protected $casts = [
        'size' => 'integer',
        'playfulness' => 'integer',
        'energy' => 'integer',
        'movement_intensity' => 'integer',
        'active' => 'integer',
        'coat_care' => 'integer',
        'dribbling' => 'integer',
        'moulting' => 'integer',
        'devotion' => 'integer',
        'human_friendly' => 'integer',
        'social' => 'integer',
        'small_animals_friendly' => 'integer',
        'child_friendly' => 'integer',
        'trainability' => 'integer',
        'training_experience' => 'integer',
        'home' => 'integer',
        'barking ' => 'integer',
        'loneliness' => 'integer',
        'hunting_instinct' => 'integer',
    ];

    /**
     * Get match score
     *
     * @return float
     */
    public function getMatchAttribute(): float
    {
        return $this->match;
    }

    /**
     * Set match score
     *
     * @param float $match
     */
    public function setMatchAttribute(float $match): void
    {
        $match = abs($match);
        $this->match = $match < 1 ? $match : 1.0;
    }

	/**
     * Export model attributes as array. Add $this->match to that array.
     *
     * @return array Model attributes array
     * @see Model::jsonSerialize() where ->toArray() is utilized
     * @see Model::toJson() where ->jsonSerialize() is utilized
     */
	public function toArray()
    {
        return array_replace(parent::toArray(), ['match' => $this->match]);
    }
}
