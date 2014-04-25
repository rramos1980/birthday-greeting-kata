<?php

class MailerService
{
    private $mailer;

    public function __construct($smtpHost, $smtpPort)
    {
        $this->smtpHost = $smtpHost;
        $this->smtpPort = $smtpPort;
    }

    public function sendMessage($sender, $subject, $body, $recipient)
    {
        // Construct the message
        $msg = Swift_Message::newInstance($subject);
        $msg
            ->setFrom($sender)
            ->setTo([$recipient])
            ->setBody($body)
        ;

        // Send the message
        $this->doSendMessage($msg);
    }

    // made protected for testing :-(
    protected function doSendMessage(Swift_Message $msg)
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
