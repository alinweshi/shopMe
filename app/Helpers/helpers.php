<?php
function formatCurrency($amount, $currency)
{
    return number_format($amount, 2) . ' ' . $currency;
}
function sendMail($template, $to, $subject, $data)
{
    \Mail::send($template, $data, function ($message) use ($to, $subject) {
        $message->to($to)
            ->subject($subject);
    });
}
