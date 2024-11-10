# TurtleApp - Telegram Survey Bot

**TurtleApp** is a simple Telegram bot designed to conduct surveys by asking users a series of predefined questions. The bot collects responses and stores them for further analysis.

## Features

- Interactive survey experience through Telegram.
- Stores user responses in a JSON file.
- Easy to customize questions.

## Getting Started

### Prerequisites

- PHP 7.4 or higher
- Composer (for dependency management)
- A Telegram bot token (you can obtain one by talking to [BotFather](https://t.me/BotFather))

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/ChernegaSergiy/TurtleApp.git
   cd TurtleApp
   ```

2. Install dependencies using Composer:

   ```bash
   composer install
   ```

3. Set your bot token in the main script. Open the `index.php` file and replace `YOUR_BOT_TOKEN` with your actual bot token:

   ```php
   $token = 'YOUR_BOT_TOKEN';
   ```

### Running the Bot

To run the bot, you need to set up a webhook or use a polling method. For simplicity, you can use the polling method by executing the following command:

```bash
php index.php
```

### Usage

- Start the bot by sending `/start` to your bot in Telegram.
- Answer the questions one by one.
- After the last question, the bot will thank you for your responses and complete the survey.

## Customization

You can customize the questions by modifying the `questions` array in the `TelegramBot` class:

```php
$this->questions = [
    "What is your name?",
    "How old are you?",
    "What is your favorite activity?",
    "What are your hobbies?"
];
```

## Contributing

Contributions are welcome and appreciated! Here's how you can contribute:

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

Please make sure to update tests as appropriate and adhere to the existing coding style.

## License

This project is licensed under the CSSM Unlimited License v2 (CSSM-ULv2). See the [LICENSE](LICENSE) file for details.

## Acknowledgments

- [Telegram Bot API](https://core.telegram.org/bots/api) - Documentation for Telegram Bot API
- [BotFather](https://t.me/BotFather) - The official bot for creating and managing Telegram bots
