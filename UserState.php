<?php

declare(strict_types=1);

namespace TurtleApp;

class UserState
{
    private string $filePath;

    private array $states = [];

    /**
     * UserState constructor.
     *
     * @param  string  $filePath  The path to the file where user states are stored.
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->load();
    }

    /**
     * Loads user states from the file.
     */
    private function load() : void
    {
        if (file_exists($this->filePath)) {
            $this->states = json_decode(file_get_contents($this->filePath), true) ?? [];
        }
    }

    /**
     * Gets the state of a user.
     *
     * @param  string  $chatId  The ID of the chat for which to get the state.
     * @return mixed The state of the user or null if not found.
     */
    public function getState(string $chatId)
    {
        return $this->states[$chatId] ?? null;
    }

    /**
     * Sets the state of a user.
     *
     * @param  string  $chatId  The ID of the chat for which to set the state.
     * @param  int  $state  The state to set for the user.
     */
    public function setState(string $chatId, int $state) : void
    {
        $this->states[$chatId] = $state;
        $this->save();
    }

    /**
     * Deletes the state of a user.
     *
     * @param  string  $chatId  The ID of the chat for which to delete the state.
     */
    public function delete(string $chatId) : void
    {
        unset($this->states[$chatId]);
        $this->save();
    }

    /**
     * Saves user states to the file.
     */
    private function save() : void
    {
        file_put_contents($this->filePath, json_encode($this->states, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
