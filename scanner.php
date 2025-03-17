<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Attendance System</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            font-size: 22px;
            margin-bottom: 15px;
        }
        #startScanner {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        #startScanner:hover {
            background-color: #0056b3;
        }
        #reader {
            width: 100%;
            max-width: 300px;
            margin-top: 20px;
            display: none;
        }
        #status {
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            min-height: 40px;
            width: 100%;
        }
        .success {
            color: green;
            background: #d4edda;
            border: 1px solid #c3e6cb;
        }
        .error {
            color: red;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
        }
        #okButton {
            display: none;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        #okButton:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Scan QR Code</h2>
        <button id="startScanner">Enable Camera</button>
        <div id="reader"></div>
        <p id="status">Waiting for scan...</p>
        <button id="okButton">OK</button>
    </div>

    <script>
        let scanner;
        let isWaitingForConfirmation = false;

        document.getElementById("startScanner").addEventListener("click", async function() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                stream.getTracks().forEach(track => track.stop());
                console.log("✅ Camera access granted.");

                document.getElementById("reader").style.display = "block";
                document.getElementById("startScanner").style.display = "none";

                startScanner();
            } catch (error) {
                console.error("❌ Camera access denied:", error);
                alert("❌ Please allow camera access in your browser settings.");
            }
        });

        function startScanner() {
            scanner = new Html5Qrcode("reader");

            scanner.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: 250 },
                function(qrCodeMessage) {
                    if (!isWaitingForConfirmation) {
                        processScan(qrCodeMessage);
                    }
                },
                function(errorMessage) {
                    console.warn("QR Scan Error: ", errorMessage);
                }
            ).catch(err => {
                console.error("❌ Failed to start scanner:", err);
                alert("❌ Failed to start the QR scanner! Try refreshing the page.");
            });
        }

        function processScan(qrCodeMessage) {
            document.getElementById("status").innerText = "Processing...";
            document.getElementById("status").className = "";
            isWaitingForConfirmation = true;

            fetch("mark_attendance.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "user_id=" + encodeURIComponent(qrCodeMessage)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("status").innerHTML = `
                        ✅ Attendance marked for <b>${data.full_name}</b><br>
                        🏫 ${data.school_selected}<br>
                        📚 ${data.year_selected}
                    `;
                    document.getElementById("status").className = "success";
                } else {
                    document.getElementById("status").innerText = "❌ " + data.error;
                    document.getElementById("status").className = "error";
                }

                document.getElementById("okButton").style.display = "block";
            })
            .catch(error => {
                console.error("❌ Error:", error);
                document.getElementById("status").innerText = "❌ Error processing QR code";
                document.getElementById("status").className = "error";
                isWaitingForConfirmation = false;
            });
        }

        document.getElementById("okButton").addEventListener("click", function() {
            document.getElementById("status").innerText = "Waiting for scan...";
            document.getElementById("status").className = "";
            document.getElementById("okButton").style.display = "none";
            isWaitingForConfirmation = false;
        });
    </script>
</body>
</html>
