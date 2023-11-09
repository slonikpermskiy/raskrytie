<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;
use Config;

class SendPlan extends Notification
{
    use Queueable;
	
	public $userid;
	public $html;
	public $month;
	

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        if (is_array($params)) {
		   $this->userid = isset($params['userid']) ? $params['userid'] : NULL;
		   $this->html = isset($params['html']) ? $params['html'] : NULL;
		   $this->month = isset($params['month']) ? $params['month'] : NULL;
		}
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)->subject(Lang::get('План отчетности на '.$this->month))
        ->view(
            ['vendor.notifications.planemail', 'vendor.notifications.planemail'],
            ['html' => new HtmlString(Lang::get($this->html))]
        );

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
