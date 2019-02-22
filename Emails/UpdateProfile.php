<?php

namespace Modules\Iprofile\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProfile extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $subject;
    public $view;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $subject
     * @param $view
     */
    public function __construct($user, $subject, $view)
    {
       $this->user=$user;
       $this->subject=$subject;
       $this->view=$view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->view)->subject($this->subject);
    }
}
