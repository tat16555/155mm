<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculation Result</title>
    <!-- เรียกใช้ Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- เรียกใช้ Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #007bff;
        }

        h2 {
            color: #6c757d;
        }

        p {
            font-size: 18px;
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        canvas {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Calculation Result</h1>

    <?php
    // แสดงผลลัพธ์จากการคำนวณ
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // เรียกใช้ฟังก์ชัน calculate_shooting_parameters ที่อยู่ในไฟล์ calculate.php
        include 'calculate.php';
        list($shooting_angle, $elevation_angle, $travel_time, $force_of_impact) = calculate_shooting_parameters(
            $_POST['latitude_origin'],
            $_POST['longitude_origin'],
            $_POST['latitude_target'],
            $_POST['longitude_target'],
            $_POST['initial_velocity']
        );
        ?>
        <div class="mt-4">
            <h2>Calculation Result:</h2>
            <p><strong>มุมการยิงที่ต้องการ:</strong> <?php echo $shooting_angle; ?> degrees</p>
            <p><strong>องศาในการหันของปืนใหญ่:</strong> <?php echo $elevation_angle; ?> degrees</p>
            <canvas id="lineChart" width="400" height="200"></canvas>
            <p><strong>ระยะเวลาเดินทางของกระสุน:</strong> <?php echo $travel_time; ?> seconds</p>
            <p><strong>แรงตกกระทบ:</strong> <?php echo $force_of_impact; ?> Newtons</p>
            <canvas id="multiAxisLineChart" width="400" height="200"></canvas>
        </div>

        <script>
            // นำเข้าข้อมูลที่ต้องการแสดงในแผนภูมิ
            var shootingAngle = <?php echo $shooting_angle; ?>;
            var elevationAngle = <?php echo $elevation_angle; ?>;
            var travelTime = <?php echo $travel_time; ?>;
            var forceOfImpact = <?php echo $force_of_impact; ?>;

            // สร้างแผนภูมิ Line Chart
            var ctxLine = document.getElementById('lineChart').getContext('2d');
            var lineChart = new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: ['Shooting Angle', 'Elevation Angle'],
                    datasets: [{
                        label: 'Angles',
                        data: [shootingAngle, elevationAngle],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                        pointRadius: 5,
                        fill: false,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });

            // สร้างแผนภูมิ Multi Axis Line Chart
            var ctxMultiAxis = document.getElementById('multiAxisLineChart').getContext('2d');
            var multiAxisLineChart = new Chart(ctxMultiAxis, {
                type: 'line',
                data: {
                    labels: ['Travel Time', 'Force of Impact'],
                    datasets: [{
                        label: 'Values',
                        data: [travelTime, forceOfImpact],
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                        pointRadius: 5,
                        fill: false,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        y1: {
                            position: 'right',
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    <?php } ?>

    <div class="mt-4">
        <a href="index.html" class="btn btn-primary">Back to Calculator</a>
    </div>
</div>

<!-- เรียกใช้ Bootstrap 5 JS และ Popper.js และ jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
