# Destroy Premium Stickers Bot

[![Bot](https://img.shields.io/badge/bot-%40DestroyPremiumStickersBot-red)](https://t.me/DestroyPremiumStickersBot)
[![Updates](https://img.shields.io/badge/updates-%40SysDevBlog-red)](https://t.me/SysDevBlog)
![GitHub](https://img.shields.io/github/license/sys-001/tg-destroypremiumstickersbot)
![Required PHP Version](https://img.shields.io/badge/php-%E2%89%A58.0-brightgreen)

:wastebasket: A very simple Telegram bot that deletes all premium stickers sent by Telegram Premium users.

## :warning: Requirements

- PHP ≥ 8.0
- A webserver

## :hammer: Deploy

- Initialize the project:

```bash
  $ git clone https://github.com/sys-001/tg-destroypremiumstickersbot
```

- Set your webhook secret in `bot.php`:

```php
const SECRET = 'YOURSECRETHERE';
```

- Set your bot webhook, it must point to `bot.php` (don't forget to include your secret!).

The bot is now ready to operate.

