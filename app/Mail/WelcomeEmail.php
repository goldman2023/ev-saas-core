<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use MailerSend\LaravelDriver\MailerSendTrait;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels, MailerSendTrait;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $array;

    public function __construct($array)
    {
        $this->array = $array;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
     {
        $to = Arr::get($this->to, '0.address');
        $template_id = 'v69oxl5e6qzl785k';
        return $this->view('emails.test_html')
            ->text('emails.test_text')
            ->mailersend(
                // Template ID
                $template_id,
                // Variables for simple personalization
                [
                    new Variable($to, ['name' => 'Your Name'])
                ],
                // Tags
                ['tag'],
                // Advanced personalization
                [
                    new Personalization($to, [
                        'var' => 'variable',
                        'number' => 123,
                        'object' => [
                            'key' => 'object-value'
                        ],
                        'objectCollection' => [
                            [
                                'name' => 'John'
                            ],
                            [
                                'name' => 'Patrick'
                            ]
                        ],
                    ])
                ],
                // Precedence bulk header
                true,
                // Send at
                new Carbon('2022-01-28 11:53:20'),
            );
    }
     }
}
