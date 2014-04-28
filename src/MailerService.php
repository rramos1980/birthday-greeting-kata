<?php

interface MailerService
{
    public function sendMessage($sender, $subject, $body, $recipient);
}