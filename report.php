<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit;
}

include('config.php');

$stmt = $pdo->query("SELECT id, rating, voice_note, mobile_number, created_at FROM feedback ORDER BY created_at DESC");
$feedbacks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .table-container {
            margin-bottom: 30px;
        }

        .logout-btn {
            margin-top: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .feedback-table th {
            text-align: center;
        }

        .feedback-table td {
            text-align: center;
        }

        @media (max-width: 768px) {

            .feedback-table th,
            .feedback-table td {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h2 class="text-primary">Manager Feedback Report</h2>
            <p>Here you can see all customer feedbacks submitted through the feedback form.</p>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover feedback-table">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Rating</th>
                            <th>Voice Note</th>
                            <th>Mobile Number</th>
                            <th>Submitted On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feedbacks as $feedback): ?>
                            <tr>
                                <td><?php echo ($feedback['id']); ?></td>
                                <td><?php echo ($feedback['rating']); ?></td>
                                <td>
                                    <?php if ($feedback['voice_note']): ?>
                                        <audio controls>
                                            <source src="<?php echo ($feedback['voice_note']); ?>" type="audio/mp3">
                                            Your browser does not support the audio element.
                                        </audio>
                                    <?php else: ?>
                                        No voice note
                                    <?php endif; ?>
                                </td>
                                <td><?php echo ($feedback['mobile_number']) ?: 'N/A'; ?></td>
                                <td><?php echo date('Y-m-d H:i:s', strtotime($feedback['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="logout-btn text-center">
            <a href="logout.php" class="btn btn-danger btn-lg">Logout</a>
        </div>
    </div>

</body>

</html>