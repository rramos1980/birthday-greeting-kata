<?php

class MailerService
{
    private $mailer;

    public function __construct($smtpHost, $smtpPort)
    {
        $this->smtpHost = $smtpHost;
        $this->smtpPort = $smtpPort;
    }

    public function buildMessage($sender, $subject, $body, $recipient)
    {
        $msg = Swift_Message::newInstance($subject);
        $msg
            ->setFrom($sender)
            ->setTo([$recipient])
            ->setBody($body)
        ;

        return $msg;
    }

    public function sendMessage($msg)
    {
        $this->getMailer()->send($msg);
    }

    private function getMailer()
    {
        if (is_null($this->mailer)) {
            $this->mailer = Swift_Mailer::newInstance(
                Swift_SmtpTransport::newInstance($this->smtpHost, $this->smtpPort)
            );
        }

        return $this->mailer;
    }
}
