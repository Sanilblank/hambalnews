<?php

namespace App\Notifications;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use NotificationChannels\FacebookPoster\FacebookPosterChannel;
use NotificationChannels\FacebookPoster\FacebookPosterPost;

class NewsWasPublished extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($news)
    {
        //
        $this->news = $news;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FacebookPosterChannel::class];
    }

    public function toFacebookPoster($notifiable) {
        $category = $this->news['category_id'];
        $reqcategory = Category::where('id', $category[0])->first();
        $link = 'https://hambalnews.com/' . $reqcategory->slug . '/' . $this->news['slug'];
        return (new FacebookPosterPost($link))->withLink($link);
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
}
