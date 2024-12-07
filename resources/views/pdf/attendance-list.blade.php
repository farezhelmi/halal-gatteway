<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            width: 100px; /* Adjust the size of the logo */
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .header p {
            font-size: 18px;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('images/logo/logo.png') }}" alt="Logo"> <!-- Your logo path -->
    <h1>List of Attendance</h1>
    <p>Training Title: {{ $training->title }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th width="35%">Name</th>
            <!-- <th>Army ID</th> -->
            <th>Identification No.</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Phone No.</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attendances as $index => $attendance)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $attendance->name }}</td>
                <!-- <td>{{ $attendance->army_id }}</td> -->
                <td>{{ $attendance->identification_no }}</td>
                <td>{{ $attendance->email }}</td>
                <td>{{ $attendance->gender }}</td>
                <td>{{ $attendance->phone_no }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
