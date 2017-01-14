<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Swift_Mailer;
use Swift_SmtpTransport;
use App\Statistik;

class MailController extends Controller
{
    public function sendmail()
    {
        $https['ssl']['verify_peer'] = FALSE;
        $https['ssl']['verify_peer_name'] = FALSE;

        // Send email notification
        $transport = Swift_SmtpTransport::newInstance(
            Config::get('mail.host'),
            Config::get('mail.port'),
            Config::get('mail.encryption')
        )
        ->setUsername(Config::get('mail.username'))
        ->setPassword(Config::get('mail.password'))
        ->setStreamOptions($https);

        $mailer = Swift_Mailer::newInstance($transport);
        Mail::setSwiftMailer($mailer);

        $data = [
            'name'              => "test",
            'modus'             => "modus",
            'geschwindigkeit'   => "geschwindigkeit",
            'gesamtleistung'    => "geschwindigkeit",
            'kilometer'         => "kilometer",
            'fahrdauer'         => "fahrdauer"
        ];

        Mail::send('mail.mail', $data, function (\Illuminate\Mail\Message $message) {
            $message->subject('HIT 2017');
            $message->from('SPIN.201617@gmail.com', 'W-HS HIT SPIN 2017');
            $message->to('SPIN.201617@gmail.com', 'Fahrer');
        });

        return "E-mail has been sent Successfully";
    }
}