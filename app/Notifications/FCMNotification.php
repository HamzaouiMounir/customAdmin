<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class FCMNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
    // this is a custom function that uses FCM notification manager to send a test downstream message to a specified device by its token
    public function toOneDevice($device_token,$title,$body){
      $optionBuiler = new OptionsBuilder();
      $optionBuiler->setTimeToLive(60*20);
      $option = $optionBuiler->build();
      $dataBuilder = new PayloadDataBuilder();
      $dataBuilder->addData(['a_data' => 'my_data']);

      $notificationBuilder = new PayloadNotificationBuilder();
      $notificationBuilder->setTitle($title)
                      ->setBody($body)
                      ->setSound('default');

      $notification = $notificationBuilder->build();
      $downstreamResponse = FCM::sendTo($device_token, $option, $notification, null);
      /*$downstreamResponse->numberSuccess();
      $downstreamResponse->numberFailure();
      $downstreamResponse->numberModification();
      //return Array - you must remove all this tokens in your database
      $downstreamResponse->tokensToDelete();
      //return Array (key : oldToken, value : new token - you must change the token in your database )
      $downstreamResponse->tokensToModify();
      //return Array - you should try to resend the message to the tokens in the array
      $downstreamResponse->tokensToRetry();
      // return Array (key:token, value:errror) - in production you should remove from your database the tokens*/
          }
}
