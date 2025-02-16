<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;


class WelcomeEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public function __construct(public User $user)
    {
        //
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
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.WelcomeEmail',
            text: 'Welcome Email',
            // with: [
            //     'userFirstName' => $this->user->first_name,
            //     'userLastName' => $this->user->last_name,
            // ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromStorage('/public/mails/welcomeMail.php')
                ->as('welcome.pdf')
                ->withMime('application/pdf'),

        ];
        // return [
        //     Attachment::fromStorageDisk('s3', '/path/to/file')
        //     ->as('name.pdf')
        //     ->withMime('application/pdf'),
        // ];
    }
}
