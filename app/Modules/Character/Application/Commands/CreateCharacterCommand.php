<?php


namespace App\Modules\Character\Application\Commands;


class CreateCharacterCommand
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $gender;
    /**
     * @var int
     */
    private $raceId;
    /**
     * @var string
     */
    private $userId;

    public function __construct(string $name, string $gender, int $raceId, string $userId)
    {
        $this->name = $name;
        $this->gender = $gender;
        $this->raceId = $raceId;
        $this->userId = $userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getRaceId(): int
    {
        return $this->raceId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
