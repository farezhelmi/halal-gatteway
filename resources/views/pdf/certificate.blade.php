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
            top: 45%; /* Adjusted for position after "Dengan ini disahkan bahawa" */
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
            top: 55%; /* Adjusted for position after "Dengan ini disahkan bahawa" */
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 25px;
            font-weight: bold;
            color: #000;
            text-align: center;
            width: 80%;
        }

        .training-type {
            position: absolute;
            top: 58%; /* Adjusted for position after "Dengan ini disahkan bahawa" */
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
            top: 65%; /* Adjusted for position after "Pada" */
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 22px;
            font-weight: bold;
            color: #000;
            text-align: center;
            width: 80%;
        }

        .venue {
            position: absolute;
            top: 73%; /* Adjusted for position after "Bertempat di" */
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 22px;
            font-weight: bold;
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

        .running-number {
            position: absolute;
            font-family: Arial, Helvetica, sans-serif;
            bottom: 1.5%; /* Position at the bottom similar to where RSMIHA-2024-040 appears */
            right: 25%; /* Position from right side */
            font-size: 18px;
            font-weight: bold;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="content">
    <div class="participant-name">{{ $data['name'] }}</div>
        <div class="training-title">{{ $data['trainingTitle'] }}</div>
        <div class="training-type">{{ $data['training_type'] }}</div>
        <div class="training-date">{{ $data['date_range'] }}</div>
        <div class="venue">{{ $data['venue'] }}</div>
        <div class="running-number">{{ $data['cert_no'] }}</div>
        
    </div>
</body>
</html>