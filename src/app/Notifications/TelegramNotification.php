<?php

namespace YFDev\System\App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramChannel;

class TelegramNotification extends Notification
{
    private $message;

    public function __construct(String $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $envMessage = '';
        switch (config('app.env')) {
            case 'local':
                $envMessage = "開發 TG測試";
                break;
            case 'test':
                $envMessage = "測試站 TG測試";
                break;
            default:
                $envMessage = "";
        }

        return TelegramMessage::create()
            ->to(config('telegram.group-chat-id'))
            ->escapedLine($envMessage)
            ->escapedLine($this->message);
    }
}
