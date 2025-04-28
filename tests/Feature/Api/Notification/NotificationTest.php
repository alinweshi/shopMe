<?php

namespace Tests\Feature\Api\Notification;

use Tests\TestCase;

class NotificationTest extends TestCase
{
    public function test_send_notification_email()
    {
        $this->withoutMiddleware();
        $response = $this->postJson("api/send-notification/email/john.doe@example.com");
        $response->assertJson(['message' => "Sending email notification to john.doe@example.com: default message"]);
        $response->assertStatus(200);
    }
    public function test_send_notification_sms()
    {
        $this->withoutMiddleware();
        $response = $this->postJson("api/send-notification/sms/254712345678");
        // dd($response);
        $response->assertJson(['message' => "Sending sms notification to 254712345678: default message"]);
        $response->assertStatus(200);
    }


    public function test_send_notification_slack()
    {
        $this->withoutMiddleware();
        $response = $this->postJson("api/send-notification/slack/john.doe@example.com");
        $response->assertJson(['message' => "Sending slack notification to john.doe@example.com: default message"]);
        $response->assertStatus(200);
    }
}
