<?php


namespace App\Modules\Character\Domain\Requests;


class CreateCharacterRequest
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @return int
     */
    public function getRaceId(): int
    {
        return $this->raceId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
}