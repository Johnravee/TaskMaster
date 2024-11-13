<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class UpcomingScheduleNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $schedule;
    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Upcoming Event: ' . $this->schedule->title)
            ->line('You have an upcoming event: ' . $this->schedule->title)
            ->line('Description: ' . $this->schedule->description)
            ->line('Event starts at: ' . Carbon::parse($this->schedule->start)->toDateTimeString())
            ->line('Event ends at: ' . Carbon::parse($this->schedule->end)->toDateTimeString());
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
