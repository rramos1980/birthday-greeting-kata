<?php

interface MailerService
{
    public function buildMessage($sender, $subject, $body, $recipient);

    public function sendMessage($msg);
}