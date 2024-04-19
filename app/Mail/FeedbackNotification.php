<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        $this->complaint = $param;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $complaint = $this->complaint;
        return $this->view('email.discussionnotification', compact('complaint'))->subject('Tim Investigasi telah menjawab Laporan No. ' . $complaint->f_noreg);
    }
}
