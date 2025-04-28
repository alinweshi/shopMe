<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class SubscriptionExpirationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $subscriptionEndDate;

    /**
     * Create a new message instance.
     */
    public function __construct($customer, $subscriptionEndDate)
    {
        $this->customer = $customer;
        $this->subscriptionEndDate = $subscriptionEndDate;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                'alinweshi@gmail.com',
                'ali nweshi'
            ),
            replyTo: [
                new Address('alinweshi@gmail.com', 'ali nweshi'),
            ],
            subject: 'Welcome Email',
        );
    }

    /**
     * Build the message.
     */
    // public function build()
    // {
    //     return $this->subject('Your Subscription is Expiring Soon')
    //         ->view('emails.subscription_expiration'); // Blade view for the email
    // }
    public function content(): Content
    {
        // Log the customer and subscription end date for debugging
        logger()->info('Customer:', ['customer' => $this->customer]);
        logger()->info('Subscription End Date:', ['date' => $this->customer->subscriptionEndDate]);

        return new Content(
            view: 'emails.subscription_expiration',
            // text: 'Your Subscription is Expiring Soon',
        );
    }
}
