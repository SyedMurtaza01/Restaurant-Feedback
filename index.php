<?php

session_start();
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="feedback.js" defer></script>
</head>
<body>
    <div class="container">
        <h1 class="my-5 text-center text-primary">We Value Your Feedback!</h1>

        <div class="text-center">
            <h3>Please rate your experience:</h3>
            <div class="smiley-ratings">
                <button class="btn btn-outline-success smiley" id="good" onclick="setRating('Good')">
                    <span class="fs-3">&#128516;</span> Good
                </button>
                <button class="btn btn-outline-warning smiley" id="okay" onclick="setRating('Okay')">
                    <span class="fs-3">&#128528;</span> Okay
                </button>
                <button class="btn btn-outline-danger smiley" id="bad" onclick="setRating('Bad')">
                    <span class="fs-3">&#128577;</span> Bad
                </button>
            </div>
        </div>

        <div class="my-4">
            <h3>Leave a voice note (optional):</h3>
            <div class="audio-feedback">
                <button id="start-recording" class="btn btn-danger">Start Recording</button>
                <button id="stop-recording" class="btn btn-danger" disabled>Stop Recording</button>
                <audio id="audio-player" controls></audio>
                <input type="hidden" id="audio-file" name="audioFile">
            </div>
        </div>

        <div class="my-4 text-center">
            <button class="btn btn-primary" onclick="submitFeedback()">Submit Feedback</button>
        </div>

        <div class="my-2 text-center">
            <a href="login.php" class="btn btn-secondary btn-lg">Manager Login</a>
        </div>
    </div>

    <script>
        let rating = '';
        let audioData = '';

        function setRating(value) {
            rating = value;
            console.log('Rating set to: ' + rating);
        }

        let mediaRecorder;
        let audioChunks = [];

        document.getElementById('start-recording').onclick = function () {
            audioChunks = [];
            navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.start();

                mediaRecorder.ondataavailable = function (event) {
                    audioChunks.push(event.data);
                };

                mediaRecorder.onstop = function () {
                    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    document.getElementById('audio-player').src = audioUrl;
                    document.getElementById('audio-file').value = audioUrl; 
                };
            });
            document.getElementById('stop-recording').disabled = false;
            document.getElementById('start-recording').disabled = true;
        };

        document.getElementById('stop-recording').onclick = function () {
            mediaRecorder.stop();
            document.getElementById('stop-recording').disabled = true;
            document.getElementById('start-recording').disabled = false;
        };

        function submitFeedback() {
            if (!rating) {
                alert('Please select a rating!');
                return;
            }

            let audioFile = document.getElementById('audio-file').value;

            $.ajax({
                url: 'insert.php',
                type: 'POST',
                data: {
                    rating: rating,
                    audioFile: audioFile,
                },
                success: function (response) {
                    alert('Feedback submitted successfully!');
                },
                error: function () {
                    alert('Error submitting feedback.');
                }
            });
        }
    </script>
</body>
</html>
