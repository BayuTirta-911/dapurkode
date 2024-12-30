<!DOCTYPE html>
<html>
<head>
    <title>A Service has been Modified</title>
</head>
<body>
    <h1>A Service has been Modified, please review.</h1>
    <p>Modified Service Details:</p>
    <ul>
        <li><strong>Service Name:</strong> {{ $serviceName }}</li>
        <li><strong>Vendor:</strong> {{ $vendorName }}</li>
        <li><strong>Description:</strong> {{ $serviceDescription }}</li>
        <li><strong>Price:</strong> Rp {{ number_format($servicePrice, 2) }}</li>
    </ul>
    <p>Please Respond As Soon As Possible</p>
</body>
</html>
