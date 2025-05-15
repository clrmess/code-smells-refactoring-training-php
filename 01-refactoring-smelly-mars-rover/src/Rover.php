<?php

declare(strict_types=1);

namespace App;

class Rover
{
    const DISPLACEMENT = 1;
    private Direction $direction;
    private Coordinates $coordinates;

    public function __construct(int $x, int $y, string $direction)
    {
        $this->direction = Direction::create($direction);
        $this->coordinates = new Coordinates($y, $x);
    }

    public function receive(string $commandsSequence): void
    {
        $commands = $this->extractCommandsFrom($commandsSequence);
        $this->processCommands($commands);

    }

    private function processCommand(CommandsEnum $command): void
    {
        switch ($command) {
            case CommandsEnum::left:
                $this->direction = $this->direction->rotateLeft();
                break;
            case CommandsEnum::right:
                $this->direction = $this->direction->rotateRight();
                break;
            case CommandsEnum::forward:
                $this->coordinates = $this->direction->move(self::DISPLACEMENT, $this->coordinates);
                break;
            default:
                $this->coordinates = $this->direction->move(-self::DISPLACEMENT, $this->coordinates);
                break;
        }
    }

    private function extractCommandsFrom(string $commandsSequence): array
    {
        $commandsSequenceLenght = strlen($commandsSequence);
        $commands = [];
        for ($i = 0; $i < $commandsSequenceLenght; ++$i) {
            $commands[] = substr($commandsSequence, $i, 1);
        }
        return $commands;
    }

    private function processCommands(array $commands): void
    {
        foreach ($commands as $command) {
            $command = CommandsEnum::from($command);
            $this->processCommand($command);
        }
    }
}