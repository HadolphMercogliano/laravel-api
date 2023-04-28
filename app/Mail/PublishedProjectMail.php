<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PublishedProjectMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $project;
    

    /**
     * Create a new message instance.
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

      $is_published = $this->project->is_published ? "pubblicato" : "rimosso";

        return new Envelope(
          subject: $this->project->title . ' ' . $is_published .' correttamente',
          
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
      
      $project = $this->project;
      $is_published =$project->is_published ? "pubblicato" : "rimosso";
      

        return new Content(
            view: 'mails.projects.published',
            with: compact('project','is_published')
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
}