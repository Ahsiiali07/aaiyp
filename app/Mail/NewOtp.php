<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOtp extends Mailable {
    use Queueable, SerializesModels;

    /** @var  $data */
    public $data;

    /**
     * NewOtp constructor.
     *
     * @param $data
     */
    public function __construct( $data ) {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $user = $this->data['user'];
        // Set the subject of the mail.
        $this->subject = trans('New OTP for your account on').' '.config('app.name', 'AA in your pocket');
        $this->to( $user );

        return $this->view( 'mails.otp_email' )->with(
            array(
                'title' => $this->subject,
                'user'  => $user,
            )
        );
    }
}
