<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactFormSubmission extends Notification
{
    use Queueable;

    protected $formData;

    public function __construct($formData)
    {
        $this->formData = $formData;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Contact Form Submission')
                    ->line('You have received a new contact form submission.')
                    ->line('Name: ' . $this->formData['firstName'] . ' ' . $this->formData['lastName'])
                    ->line('Email: ' . $this->formData['email'])
                    ->line('Message:')
                    ->line($this->formData['message']);
    }
}
