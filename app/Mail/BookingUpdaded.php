<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingUpdaded extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        switch ($this->booking->status) {
            case 'approved':
                return $this->subject('SkillBox.Booking - бронирование одобрено')
                    ->view('mail.booking-approved');
            case 'canceled':
                return $this->subject('SkillBox.Booking - отель не подтвердил бронирование')
                    ->view('mail.booking-approved');
            case 'checkin':
                return $this->subject('SkillBox.Booking - поздравляем с заселение в отел')
                    ->view('mail.booking-checkin');
            case 'used':
                return $this->subject('SkillBox.Booking - спасибо, за проведенное у нас время')
                    ->view('mail.booking-used');
            case 'reviewed':
                return $this->subject('SkillBox.Booking - спасибо, за Ваш отзыв')
                    ->view('mail.booking-reviewed');
        }
    }
}
