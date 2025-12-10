<!DOCTYPE html>
<html>
<head>
    <title>Application Result</title>
</head>
<body>
    <h3>Hello {{ $application->name }},</h3>

    @if($application->status === 'accepted')
        <p>Congratulations! Your application to <strong>{{ $application->university->name }}</strong> has been accepted.</p>
        <p>We look forward to welcoming you!</p>
    @else
        <p>Thank you for your interest in <strong>{{ $application->university->name }}</strong>.</p>
        <p>Unfortunately, we are unable to offer you a place at this time.</p>
        <p>We wish you the best in your future endeavors.</p>
    @endif

    <p>Best regards,<br>UniXplorer Team</p>
</body>
</html>