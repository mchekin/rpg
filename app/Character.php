<?php

namespace App;

use App\Contracts\Models\BattleInterface;
use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\ImageInterface;
use App\Contracts\Models\LevelInterface;
use App\Contracts\Models\LocationInterface;
use App\Contracts\Models\RaceInterface;
use App\Contracts\Models\UserInterface;
use App\Services\FilesystemService\ImageFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @property UserInterface user
 * @property LocationInterface location
 * @property integer id
 * @property integer hit_points
 * @property integer xp
 * @property LevelInterface level
 * @property integer available_attribute_points
 * @property integer battles_won
 * @property integer battles_lost
 * @property integer strength
 * @property integer agility
 * @property integer constitution
 * @property integer location_id
 * @property RaceInterface race
 * @property string gender
 * @property int total_hit_points
 * @property int victor_xp_gained
 */
class Character extends Model implements CharacterInterface
{

    protected $guarded = ['user_id'];

    /**
     * Get the user of the character
     *
     * @return BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Get the user of the character
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user of the character
     *
     * @return BelongsTo
     */
    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    /**
     * Get the current location of the character
     *
     * @return BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the user of the character
     *
     * @return BelongsTo
     */
    public function profilePicture()
    {
        return $this->belongsTo(Image::class, 'profile_picture_id');
    }

    /**
     * @return HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * @return HasMany
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'to_id');
    }

    /**
     * @return HasMany
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'from_id');
    }

    /**
     * @return HasMany
     */
    public function attacks()
    {
        return $this->hasMany(Battle::class, 'attacker_id');
    }

    /**
     * @return HasMany
     */
    public function defends()
    {
        return $this->hasMany(Battle::class, 'defender_id');
    }

    public function sendMessageTo(CharacterInterface $companion, string $content): CharacterInterface
    {
        $this->sentMessages()->create([
            'to_id' => $companion->getId(),
            'content' => $content,
        ]);

        return $this;
    }

    public function isYou(): bool
    {
        return $this->isPlayerCharacter() && $this->user->isCurrentAuthenticatedUser();
    }

    public function isPlayerCharacter(): bool
    {
        return !is_null($this->user);
    }

    public function isNPC(): bool
    {
        return is_null($this->user);
    }

    public function getProfilePictureFull(): string
    {
        if ($this->profilePicture()->exists())
        {
            /** @var ImageInterface $image */
            $image = $this->profilePicture()->first();

            return $image->getFilePathFull();
        }

        return $this->race->getImageByGender($this->gender);
    }

    public function getProfilePictureSmall(): string
    {
        if ($this->profilePicture()->exists())
        {
            /** @var ImageInterface $image */
            $image = $this->profilePicture()->first();

            return $image->getFilePathSmall();
        }

        return 'svg/avatar.svg';
    }

    public function getRaceName(): string
    {
        return $this->race->getName();
    }

    public function getLevelNumber():int
    {
        return $this->level->getId();
    }

    public function getNextLevelXp():int
    {
        return $this->level->getNextLevelXpThreshold();
    }

    public function getLocationName():string
    {
        return $this->location->getName();
    }

    public function attack(CharacterInterface $defender): BattleInterface
    {
        return DB::transaction(function () use ($defender) {

            /** @var BattleInterface|Model $battle */
            $battle = $this->attacks()->create([
                'defender_id' => $defender->getId(),
                'location_id' => $defender->getLocationId(),
            ]);

            $battle->execute();

            $battle->push();

            return $battle;
        });
    }

    public function applyAttributeIncrease(string $attribute): CharacterInterface
    {
        if ($this->available_attribute_points) {

            $this->available_attribute_points--;
            $this->$attribute++;

            if ($attribute === 'constitution') {
                return $this->increaseTotalHitPoints();
            }
        }

        return $this;
    }

    protected function checkLevelUp(): CharacterInterface
    {
        while ($this->shouldLevelUp($nextLevel = $this->level->nextLevel())) {

            // update character's level
            $this->level()->associate($nextLevel);

            // add attribute points
            $this->available_attribute_points++;
        }

        return $this;
    }

    protected function shouldLevelUp($nextLevel): bool
    {
        return !is_null($nextLevel) && ($this->xp > $this->level->getNextLevelXpThreshold());
    }

    protected function increaseTotalHitPoints(): Character
    {
        $this->total_hit_points += 10 + self::throwTwoDices();

        return $this;
    }

    public static function createCharacter(Request $request, RaceInterface $race): CharacterInterface
    {
        $totalHitPoints = self::calculateHP($race->getConstitution());

        return new Character([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),

            'xp' => 0,
            'level_id' => 1,
            'money' => 0,
            'reputation' => 0,

            'strength' => $race->getStrength(),
            'agility' => $race->getAgility(),
            'constitution' => $race->getConstitution(),
            'intelligence' => $race->getIntelligence(),
            'charisma' => $race->getCharisma(),

            'hit_points' => $totalHitPoints,
            'total_hit_points' => $totalHitPoints,

            'race_id' => $race->getId(),
            'location_id' => $race->getStartingLocationId(),
        ]);
    }

    protected static function throwTwoDices(): int
    {
        return self::throwOneDice() + self::throwOneDice();
    }

    protected static function throwOneDice(): int
    {
        return rand(1, 6);
    }

    protected static function calculateHP(int $constitution): int
    {
        return $constitution * 10 + self::throwTwoDices();
    }

    public function getId()
    {
        return $this->id;
    }

    public function isAlive(): bool
    {
        return $this->hit_points > 0;
    }

    public function incrementWonBattles(): CharacterInterface
    {
        $this->battles_won++;

        return $this;
    }

    public function incrementLostBattles(): CharacterInterface
    {
        $this->battles_lost++;

        return $this;
    }

    public function addXp(int $xp): CharacterInterface
    {
        $this->xp += $xp;

        return $this->checkLevelUp();
    }

    public function applyDamage($damageDone): CharacterInterface
    {
        $this->hit_points -= $damageDone;

        return $this;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function getAgility(): int
    {
        return $this->agility;
    }

    public function getConstitution(): int
    {
        return $this->constitution;
    }

    public function getLocationId(): int
    {
        return $this->location_id;
    }

    public function addImage(ImageFiles $imageFiles): ImageInterface
    {
        /** @var ImageInterface $image */
        $image = $this->images()->create([
            'file_path_full' => $imageFiles->getFullSizePath(),
            'file_path_small' => $imageFiles->getSmallSizePath(),
            'file_path_icon' => $imageFiles->getIconSizePath(),
        ]);

        return $image;
    }

    public function addProfilePicture(ImageFiles $imageFiles): CharacterInterface
    {
        $image = $this->addImage($imageFiles);

        $this->profilePicture()->associate($image)->save();

        return $this;
    }

    public function isOnline(): bool
    {
        if($this->isNPC()) {
            return true;
        }

        return $this->user->isOnline();
    }

    public function getHitPoints(): int
    {
        return $this->hit_points;
    }

    public function getTotalHitPoints(): int
    {
        return $this->total_hit_points;
    }
}
