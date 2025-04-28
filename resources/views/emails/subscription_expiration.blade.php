<!DOCTYPE html>
<html>

<head>
    <title>Subscription Expiration</title>
</head>

<body>
    <h1>Hello, {{ $customer->first_name }} {{ $customer->last_name }}!</h1>
    <p>Your subscription is expiring soon.</p>
    <p>Subscription End Date: {{ $customer->subscriptionEndDate}}</p>
    <p>Please renew your subscription to continue enjoying our services.</p>
    <p>Thank you,</p>
    <p>{{ config('app.name') }}</p>
</body>

</html>