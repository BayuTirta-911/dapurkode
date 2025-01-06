<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\AffiliateRequest;
use App\Models\User;


class AffiliateRequestNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $affiliateRequest;
    public $user;
    /**
     * Create a new message instance.
     */
    public function __construct($affiliateRequest)
    {
        $this->affiliateRequest = $affiliateRequest;
        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Affiliate Request Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.affiliate_request_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        
        return $this->subject('New Affiliate Request')
            ->view('emails.affiliate_request_notification')
            ->with([
                'userId' => $this->affiliateRequest->user_id,
                'userDescription' => $this->affiliateRequest->description,
                'userMarketingPlan' => $this->affiliateRequest->marketing_plan,
            ]);
    }
}
