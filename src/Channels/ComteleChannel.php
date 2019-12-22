<?php

namespace Andremellow\Comtele\Channels;

use Andremellow\Comtele\Messages\ComteleMessage;
use Illuminate\Notifications\Notification;


class ComteleChannel
{
    
    /**
     * Create a new Comtele channel instance.
     *
     * @param  \Comtele\Client  $comtele
     * @param  string  $from
     * @return void
     */
    public function __construct()
    {
    }
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return \Comtele\Message\Message
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('comtele', $notification)) {
            return;
        }
        $message = $notification->toComtele($notifiable);
        if (is_string($message)) {
            $message = new ComteleMessage($message);
        }

        $baseUrl = config('comtele.send.url');

        $param = [
            'Sender'    => $this->getSender($message),
            'Receivers' => $to,
            'Content'   => $message->getContent()
        ];

        $url = $baseUrl.'?'.http_build_query($param);

        $this->submit($url);
       // curl --request GET \
       //    --url 'https://sms.comtele.com.br/api/v2/send?Sender=Sender&Receivers=Receivers&Content=Content' \
       //    --header 'auth-key: de111c12-9f3c-4b58-b72a-0415d9ba4234'
    }

    public function getSender(ComteleMessage $message)
    {
        $sender = $message->getSender();
        
        if(empty($sender) || $sender === null){
            return config('comtele.send.sender');
        }

        return $sender;

    }

    public function submit($url)
    {
        $ch = curl_init(); 

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //SET TO GET
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'auth-key: '.config('comtele.auth_key')
        ]);

        // $output contains the output string
        $output = curl_exec($ch);

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);


        // close curl resource to free up system resources
        curl_close($ch); 
        dd($output, $code);
    }
}