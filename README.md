# Laravel Comtele

Package to connect to comtele.com.br.

### Install the package using composer
```sh
composer require andremellow/laravel-comtele
```

### You can export the configuration file 
You should not need to export the vendor file, since you can overhide all configurations on the .env file.
But just in case you need, just run the folling command

```sh
php artisan vendor:publish --provider="Andremellow\Comtele\ComteleChannelServiceProvider"
```

### Add your `Auth Key` and `Default Sender` to your .env file
```sh
COMTELE_AUTH_KEY=xxxxxxxxx-xxxxxx-xxxxxx-xxxxxx-xxxxxxxxx
COMTELE_SEND_SENDER="Default Sender here"
```

At this point, just follow Laravel Notification Documentation

Now add the Notifiable https://laravel.com/docs/6.x/notifications

### Create a Notification
```sh
php artisan make:notification InvoicePaid
```

### Using The Notifiable Trait

Add Notification Trail to the User class
```sh
<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
}
```

### Update the Notification Class

Now go to your notification Class and add `comtele` channel to the via method

```
/**
 * Get the notification's delivery channels.
 *
 * @param  mixed  $notifiable
 * @return array
 */
public function via($notifiable)
{
    return ['comtele'];
}
```

Once you fire the notification, laravel will look the `toCometele` method. So add it to the Notification Class
```
    /**
     * Get the Comtele / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return ComteleMessage
     */
    public function toComtele($notifiable)
    {
        return (new ComteleMessage)
            ->sender("Add your sender note here")
            ->content("Add your message here");
    }
```

Don't forget to import the `ComteleMesssage` class

```
use Andremellow\Comtele\Messages\ComteleMessage;
```

### Getting user's phone number

Go back to the `User` class and add a new method `routeNotificationForComtele`

```
/**
     * Route notifications for the Comtele channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForComtele($notification = null)
    {
        return $this->phone_number;
    }
```

Diffrent of Nexmo, Comtele only sends message to Brazilan carriers. And because of that you don't need to the country number to the phone number. 
Just use like `319xxxxxxxxx`

Any question, feel free to reach out to me at andremellow@gmail.com
