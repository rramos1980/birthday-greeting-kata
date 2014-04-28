<?php

class SwiftMailerService implements MailerService
{
    private $mailer;

    public function __construct($smtpHost, $smtpPort)
    {
        $this->smtpHost = $smtpHost;
        $this->smtpPort = $smtpPort;
    }

    public function sendMessage($sender, $subject, $body, $recipient)
    {
        $this->getMailer()->send(
            $this->buildMessage($sender, $subject, $body, $recipient)
        );
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

    private function buildMessage($sender, $subject, $body, $recipient)
    {
        $msg = Swift_Message::newInstance($subject);
        $msg
            ->setFrom($sender)
            ->setTo([$recipient])
            ->setBody($body)
        ;

        return $msg;
    }
}
