# ClickSend notifications channel for Laravel 5.3

This package makes it easy to send [Clicksend notifications](https://www.clicksend.com/en/api-docs/) with Laravel 5.3.

## Installation

You can install the package via composer:

``` bash
composer require omarusman/laravel_notification_clicksend
```

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    ClickSendNotification\ClicksendProvider::class,
],
```

### Setting up your ClickSend account

Add your ClickSend Username and API Key to your `config/services.php`:

```php
// config/services.php
...
'clicksend' => [
    'username' => env('CLICKSEND_USERNAME'),
    'api_key' => env('CLICKSEND_API_KEY'),
    'base_uri' => env('CLICKSEND_BASE_URI'), // optional
],
...
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use ClickSendNotification\ClicksendChannel;
use ClickSendNotification\ClicksendSmsMessage;
use Illuminate\Notifications\Notification;

class OrderPaid extends Notification
{
    public function via($notifiable)
    {
        return [ClicksendChannel::class];
    }

    public function toClicksend($notifiable)
    {
        return (new ClicksendSmsMessage())
            ->content("Thank you! You successfully paid for your Order #123");
    }
}
```

In order to let your Notification know which phone are you sending/calling to, the channel will look for the `sms` attribute of the Notifiable model. If you want to override this behaviour, add the `routeNotificationForClicksend` method to your Notifiable model.

```php
public function routeNotificationForClicksend()
{
    return '+1234567890';
}
```

### Available Message methods

#### ClicksendSmsMessage

- `content('')`: Accepts a string value for the notification body.