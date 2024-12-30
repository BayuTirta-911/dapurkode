<!DOCTYPE html>
<html>
<head>
    <title>New Service Notification</title>
</head>
<body>
    <h1>New Service Added</h1>
    <p>A new service has been added to the platform:</p>
    <ul>
        <li><strong>Service Name:</strong> {{ $serviceName }}</li>
        <li><strong>Vendor:</strong> {{ $vendorName }}</li>
        <li><strong>Description:</strong> {{ $serviceDescription }}</li>
        <li><strong>Price:</strong> Rp {{ number_format($servicePrice, 2) }}</li>
    </ul>
    <p>Please Respond As Soon As Possible</p>
</body>
</html>
