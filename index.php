<?php
session_start();
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <title>Restaurant Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="my-5 text-center text-primary">We Value Your Feedback!</h1>

        <div class="text-center">
            <h3 class="text-center">Please rate your experience:</h3>
            <div class="smiley-ratings text-center">
                <button class="btn btn-outline-success smiley" id="good" onclick="setRating('Good')">
                    <span style="font-size: 50px;">&#128516;</span> Good
                </button>
                <button class="btn btn-outline-warning smiley" id="okay" onclick="setRating('Okay')">
                    <span style="font-size: 50px;">&#128528;</span> Okay
                </button>
                <button class="btn btn-outline-danger smiley" id="bad" onclick="setRating('Bad')">
                    <span style="font-size: 50px;">&#128577;</span> Bad
                </button>
            </div>
        </div>

        <div class="my-4">
            <h3 class="text-center">Leave a voice note (optional):</h3>
            <div class="audio-feedback text-center">
                <button id="toggle-recording" class="btn btn-success">Start Recording</button>
                <audio id="audio-player" controls></audio>
                <input type="hidden" id="audio-file" name="audioFile">
            </div>
        </div>

        <div class="my-2">
            <h3 class="text-center">Enter your mobile number (optional):</h3>
            <div class="d-flex justify-content-center">
                <input type="text" class="form-control col-10 col-sm-6 col-md-4" id="mobile-number" placeholder="Enter your mobile number" style="max-width: 450px; padding: 10px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: box-shadow 0.3s ease;">
            </div>
        </div>

        <div class="my-4 text-center">
            <button class="btn btn-primary" onclick="submitFeedback()">Submit Feedback</button>
        </div>

        <div class="my-4 text-center">
            <a href="login.php" class="btn btn-primary btn-lg" style="border-radius: 12px; padding: 8px 30px; font-size: 1.1rem; transition: background-color 0.3s ease, transform 0.3s ease;">
                Manager Login
            </a>
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

        document.getElementById('toggle-recording').onclick = function() {
            if (mediaRecorder && mediaRecorder.state === "recording") {
                mediaRecorder.stop();
                document.getElementById('toggle-recording').textContent = "Start Recording";
                document.getElementById('toggle-recording').classList.remove('btn-danger');
                document.getElementById('toggle-recording').classList.add('btn-success');
            } else {
                audioChunks = [];
                navigator.mediaDevices.getUserMedia({
                    audio: true
                }).then(stream => {
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.start();

                    mediaRecorder.ondataavailable = function(event) {
                        audioChunks.push(event.data);
                    };

                    mediaRecorder.onstop = function() {
                        const audioBlob = new Blob(audioChunks, {
                            type: 'audio/wav'
                        });
                        const audioUrl = URL.createObjectURL(audioBlob);
                        const formData = new FormData();
                        formData.append("audio", audioBlob, "feedback_audio.wav");

                        $.ajax({
                            url: 'upload_audio.php',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                const audioFilePath = JSON.parse(response).filePath;
                                document.getElementById('audio-player').src = audioUrl;
                                document.getElementById('audio-file').value = audioFilePath;
                            }
                        });
                    };
                });
                document.getElementById('toggle-recording').textContent = "Stop Recording";
                document.getElementById('toggle-recording').classList.remove('btn-success');
                document.getElementById('toggle-recording').classList.add('btn-danger');
            }
        };

        function submitFeedback() {
            if (!rating) {
                alert('Please select a rating!');
                return;
            }

            let audioFile = document.getElementById('audio-file').value;
            let mobileNumber = document.getElementById('mobile-number').value;

            $.ajax({
                url: 'insert.php',
                type: 'POST',
                data: {
                    rating: rating,
                    audioFile: audioFile,
                    mobileNumber: mobileNumber,
                },
                success: function(response) {
                    alert('Feedback submitted successfully!');
                    clearForm();
                },
                error: function() {
                    alert('Error submitting feedback.');
                }
            });
        }

        function clearForm() {
            rating = '';
            document.querySelectorAll('.smiley').forEach(button => {
                button.classList.remove('active');
            });

            document.getElementById('mobile-number').value = '';
            document.getElementById('audio-file').value = '';
            document.getElementById('audio-player').src = '';
            document.getElementById('toggle-recording').disabled = true;
        }
    </script>
</body>

</html>