<?php

function sendPayload(string $method, array $params): void
{
    $params['method'] = $method;
    $payload = json_encode($params);
    header('Content-Type: application/json');
    header('Content-Length: ' . strlen($payload));
    echo $payload;
}

const SECRET = 'YOURSECRETHERE';

$secret = $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] ?? null;

if (!is_null(SECRET) and (is_null($secret) or !hash_equals(SECRET, $secret))) {
    header('HTTP/1.1 401 Unauthorized');
    die('Unauthorized.');
}

$update = json_decode(file_get_contents('php://input'));

if (empty($update)) {
    die('No update.');
}

$message = $update->message ?? $update->edited_message ?? $update->channel_post ?? $update->edited_channel_post ?? null;

if (!is_null($message) and $message->sticker?->premium_animation ?? false) {
    if (!empty($message->sender_chat) or empty($message->from) or ($message->from->is_premium ?? false)) {
        sendPayload('deleteMessage', ['chat_id' => $message->chat->id, 'message_id' => $message->message_id]);
        exit(0);
    }
}
if ('private' == $message->chat->type and '/start' == $message->text) {
    $text = "*Hi there\\!* \u{1F44B}\n\nJust *add me to any group or channel with the _\"Delete messages\"_ permission*, I'll take care of the rest\\.";
    $keyboard = [
        [
            [
                'text' => "\u{1F4E2} Add to channel",
                'url' => 'https://t.me/DestroyPremiumStickersBot?startchannel&admin=delete_messages'
            ],
            [
                'text' => "\u{1F465} Add to group",
                'url' => 'https://t.me/DestroyPremiumStickersBot?startgroup&admin=delete_messages'
            ]
        ],
        [
            ['text' => "\u{1F9D1}\u{200D}\u{1F4BB} Author", 'url' => 'https://t.me/sys001'],
            ['text' => "\u{1F5C4}\u{FE0F} Source code", 'url' => 'https://github.com/sys-001/tg-destroypremiumstickersbot']
        ],
        [['text' => "\u{2B50} Rate me", 'url' => 'https://t.me/BotsArchive/2460']]
    ];
    sendPayload(
        'sendMessage',
        [
            'chat_id' => $message->chat->id,
            'text' => $text,
            'parse_mode' => 'MarkdownV2',
            'reply_markup' => ['inline_keyboard' => $keyboard]
        ]
    );
    exit(0);
}
