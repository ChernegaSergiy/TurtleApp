<?php

declare(strict_types=1);

namespace TurtleApp;

class TelegramBot
{
    private string $token;

    private string $apiUrl;

    private array $questions;

    private UserState $userState;

    /**
     * TelegramBot constructor.
     *
     * @param  string  $token  The bot token obtained from BotFather.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
        $this->apiUrl = "https://api.telegram.org/bot{$token}/";
        $this->questions = [
            'What is your name?',
            'How old are you?',
            'What is your favorite activity?',
            'What are your hobbies?',
        ];
        $this->userState = new UserState('user_states.json');
    }

    /**
     * Sends a message to the user.
     *
     * @param  int  $chatId  The ID of the chat where the message should be sent.
     * @param  string  $text  The text of the message.
     */
    public function sendMessage(int $chatId, string $text) : void
    {
        file_get_contents("{$this->apiUrl}sendMessage?chat_id={$chatId}&text=" . urlencode($text));
    }

    /**
     * Processes the received update from Telegram.
     *
     * @param  array  $update  An array containing the update from Telegram.
     */
    public function processUpdate(array $update) : void
    {
        $chatId = $update['message']['chat']['id'];
        $message = $update['message']['text'] ?? '';
        $currentState = $this->userState->getState((string) $chatId);

        if (0 === strpos($message, '/start')) {
            $this->userState->setState((string) $chatId, 0);
            $this->sendMessage($chatId, "Hello! Let's start the survey.");
            $this->askQuestion($chatId, 0);
        } elseif (is_numeric($currentState)) {
            $this->saveResponse($chatId, $message, (int) $currentState);
            $nextQuestionIndex = (int) $currentState + 1;
            if ($nextQuestionIndex < count($this->questions)) {
                $this->askQuestion($chatId, $nextQuestionIndex);
            } else {
                $this->sendMessage($chatId, 'Thank you for your responses! The survey is complete.');
                $this->userState->delete($chatId);
            }
        }
    }

    /**
     * Asks a question to the user.
     *
     * @param  int  $chatId  The ID of the chat where the question should be sent.
     * @param  int  $questionIndex  The index of the question in the questions array.
     */
    private function askQuestion(int $chatId, int $questionIndex) : void
    {
        $this->sendMessage($chatId, $this->questions[$questionIndex]);
        $this->userState->setState((string) $chatId, $questionIndex);
    }

    /**
     * Saves the user's response to the question.
     *
     * @param  int  $chatId  The ID of the user's chat.
     * @param  string  $response  The user's response.
     * @param  int  $questionIndex  The index of the question being answered.
     */
    private function saveResponse(int $chatId, string $response, int $questionIndex) : void
    {
        $responses = json_decode(file_get_contents('responses.json'), true) ?? [];
        $responses[(string) $chatId]['responses'][$questionIndex] = $response;
        file_put_contents('responses.json', json_encode($responses, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
