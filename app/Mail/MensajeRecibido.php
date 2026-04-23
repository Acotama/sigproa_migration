<?php

namespace sayhuite\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use DateTime;

class MensajeRecibido extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject;
    public $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $now = new DateTime();
        $now = $now->modify('-1 days');
        $this->msg = $message;
        $this->subject = 'Reporte Diario de Inversión Pública - ' . $now->format('d-m-Y');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.EmailReporteDiario')
        ->attach($this->msg['archivo'],[
            'as'=>$this->msg['nombre']
        ]);
    }
}
