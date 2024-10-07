<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        @page {
        margin: 0px; /* Remove all page margins */
        }

        body {
            background-image: url({{ $imgPath }});
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center top;
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            position: relative;
            font-family: Arial, sans-serif;
        }

        .content {
        position: relative;
        align-items: center;
        justify-content: center; 
        /* No need to center the entire content */
        }

        .name {
            position: absolute;
            top: 37%; /* Adjust this value based on your template */
            left: 50%; /* Adjust this value based on your template */
            transform: translate(-50%, -50%);
            font-size: 60px; /* Change size as necessary */
            font-weight: bold;
            color: #333;
        }

        .trainingTitle {
            position: absolute;
            top: 48%; /* Adjust this value for training title */
            left: 50%; /* Adjust this value for training title */
            transform: translate(-50%, -50%);
            font-size: 38px; /* Change size as necessary */
            color: #666;
        }

        .date {
            position: absolute;
            top: 61%; /* Adjust this value for date */
            left: 50%; /* Adjust this value for date */
            transform: translate(-50%, -50%);
            font-size: 36px; /* Change size as necessary */
            color: #666;
        }
    </style>
</head>
<body>
    <div class="content">
        <!-- <div class="name">{{ $data['name'] }}</div> -->
        <div class="name">{{ $data['name'] }}</div>
        <div class="trainingTitle"><b>{{ $data['trainingTitle'] }}<b></div>
        <div class="date">{{ $data['date'] }}</div>
    </div>
</body>
</html>