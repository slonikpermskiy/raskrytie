<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Config;

class PayBill extends Notification
{
    use Queueable;
	
	public $userid;
	public $time;
	public $summ;
	public $weektext;	
	public $fromemail;
	

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        if (is_array($params)) {
		   $this->userid = isset($params['userid']) ? $params['userid'] : NULL;
		   $this->time = isset($params['time']) ? $params['time'] : NULL;
		   $this->summ = isset($params['summ']) ? $params['summ'] : NULL;
		   
		   if ($this->time === 1) {
			   $this->weektext = 'месяц';
		   } else if ($this->time === 3) {
			   $this->weektext = 'месяца';
		   } else if ($this->time === 6 | $this->time === 12) {
			   $this->weektext = 'месяцев';
		   }
		   
		   $this->fromemail = config('mail.from.address');
		   
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
		return (new MailMessage)
			->subject(Lang::get('Инструкция по оплате доступа'))
			->line(Lang::get('На данный момент доступна оплата только с помощью перевода на карту Сбербанка.'))
			->line(Lang::get('Для оплаты доступа Премиум сроком на '.$this->time.' '.$this->weektext.' переведите '.$this->summ.' рублей на карту Сбербанка 4276 4900 1028 9645.'))
			->line(Lang::get('Получатель платежа Дмитрий Сергеевич П.'))
			->line(Lang::get('Для ускорения обработки, в комментарии к платежу укажите - '.$this->time.'M'.$this->userid.', либо отправьте чек об оплате на электронный адрес '.$this->fromemail.'.'));
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
