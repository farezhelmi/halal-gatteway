<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sijil Penyertaan</title>
    <style>
        @page {
            margin: 0px; /* Remove all page margins */
        }

        body {
            background-image: url({{ $imgPath }});
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            position: relative;
            font-family: 'Times New Roman', serif; /* More formal font for certificates */
        }

        .content {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .participant-name {
            position: absolute;
            top: 48%; /* Adjusted for position after "Dengan ini disahkan bahawa" */
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 28px;
            font-weight: bold;
            color: #000;
            text-align: center;
            width: 80%;
        }

        .training-title {
            position: absolute;
            top: 56%; /* Adjusted for position after "Dengan ini disahkan bahawa" */
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 25px;
            font-weight: bold;
            color: #000;
            text-align: center;
            width: 80%;
        }

        .training-date {
            position: absolute;
            top: 62%; /* Adjusted for position after "Pada" */
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 22px;
            color: #000;
            text-align: center;
            width: 80%;
        }

        .venue {
            position: absolute;
            top: 68%; /* Adjusted for position after "Bertempat di" */
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 22px;
            color: #000;
            text-align: center;
            width: 80%;
        }

        .certificate-id {
            position: absolute;
            bottom: 15%;
            left: 15%;
            font-size: 14px;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="participant-name">{{ $data['name'] }}</div>
        <div class="training-title">{{ $data['trainingTitle'] }}</div>
        <div class="training-date">{{ $data['date'] }}</div>
        <div class="venue">{{ $data['venue'] }}</div>
        
    </div>
</body>
</html>