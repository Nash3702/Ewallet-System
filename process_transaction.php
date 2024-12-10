<?php
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Include Composer's autoloader to load PHPMailer classes
require 'autoload.php';

if (isset($_POST['submit'])) {
    $amount = $_POST['amount'];
    $staffId = $_POST['staff_id'];  // Capture staff_id from POST data

    // Debugging output (remove after testing)
    echo "Received Amount: $amount, Staff ID: $staffId"; 

    // Call the function to process the transaction
    processTransaction($staffId, $amount);  // Pass both staffId and amount to the function
}


// Email sending function
function sendEmail($to, $subject, $message, $vendorName, $amount, $staffId) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'murugan5949@gmail.com'; // Gmail address
        $mail->Password = 'rkhk iama vjhm abwt'; // Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('murugan5949@gmail.com', 'E-Wallet System');
        $mail->addAddress($to);
        $mail->Subject = $subject;

        // Format the amount correctly
        $formattedAmount = number_format($amount, 2); // Ensure the amount is formatted with 2 decimal places

        // Define the timezone and get the current date
$timezone = new DateTimeZone('Asia/Kuala_Lumpur');  // Adjust the timezone if necessary
$date = new DateTime('now', $timezone); // Get current date and time
$formattedDate = $date->format('Y-m-d H:i:s'); // Format the date for the email
        // HTML Email Body
        $mail->Body = "
        <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        color: #333;
                    }
                    .email-container {
                        background-color: #f9f9f9;
                        padding: 20px;
                        border-radius: 10px;
                        border: 1px solid #ddd;
                        width: 80%;
                        margin: auto;
                        text-align: center;
                    }
                    .email-header {
                        font-size: 1.5em;
                        font-weight: bold;
                        margin-bottom: 20px;
                    }
                    .email-content {
                        margin-bottom: 20px;
                    }
                    .highlight {
                        color: #2a9d8f;
                        font-weight: bold;
                    }
                    .footer {
                        font-size: 0.9em;
                        color: #888;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>E-Wallet System Notification</div>
                    <div class='email-content'>
                        A new transaction has been processed by <span class='highlight'>{$vendorName}</span>.
                        <br><br>
                        <strong>Amount:</strong> RM{$formattedAmount}
                        <br>
                        <strong>Date:</strong> {$formattedDate}
                    </div>
                    <div class='footer'>Thank you for using our service!</div>
                </div>
            </body>
        </html>
        ";

        // Plaintext fallback (alt body) for non-HTML email clients
        $mail->AltBody = "Staff ID {$staffId} has been debited with RM{$formattedAmount}.\nDate: {$formattedDate}";

        // Make sure the email format is HTML
        $mail->isHTML(true); 

        // Try sending the email
        $mail->send();
        echo "Email sent successfully!";
    } catch (Exception $e) {
        // If there's an error, display it
        echo "Failed to send email. Error: {$mail->ErrorInfo}";
    }
}


// Function to process the transaction
function processTransaction($staffId, $amount) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'e_wallet_db');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Start a transaction for safe updates
    $conn->begin_transaction();

    try {

        // Fetch current balance of the staff
        $staffQuery = "SELECT balance FROM staff WHERE staff_id = ?";
        $stmt = $conn->prepare($staffQuery);
        $stmt->bind_param("i", $staffId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Staff ID not found.");
        }

        $staffData = $result->fetch_assoc();
        $currentBalance = $staffData['balance'];

        // Check if the balance is sufficient
        if ($currentBalance < $amount) {
            throw new Exception("Insufficient balance.");
        }

        // Deduct the amount
        $newBalance = $currentBalance - $amount;

        // Update the staff's balance
        $updateQuery = "UPDATE staff SET balance = ? WHERE staff_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("di", $newBalance, $staffId);
        $updateStmt->execute();

        // Log the transaction (include vendor_id)
        $vendorId = 1;  // Example vendor ID, adjust as needed
        $transactionQuery = "INSERT INTO transactions (staff_id, vendor_id, amount, date) VALUES (?, ?, ?, NOW())";
        $transactionStmt = $conn->prepare($transactionQuery);
        $transactionStmt->bind_param("iid", $staffId, $vendorId, $amount);  // 'i' for integer, 'd' for double
        $transactionStmt->execute();

        // Commit the transaction
        $conn->commit();
        echo "Transaction successful. Email notification will be sent.";

        // Send email notification
        $staffEmail = "savinnash02@gmail.com"; // Replace with actual staff email
        $subject = "Transaction Notification";
        $vendorName = "Vendor 1"; // Example vendor name
        sendEmail($staffEmail, $subject, "Transaction processed successfully.", $vendorName, $amount, $staffId);

    } catch (Exception $e) {
        // Rollback the transaction on failure
        $conn->rollback();
        echo "Transaction failed: " . $e->getMessage();
    }

    $conn->close();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Transaction</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="vendor.css">
</head>
<body>
    <div class="form-container">
        <h2>Process Transaction</h2>
        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
        <form action="process_transaction.php" method="POST">
    <div class="form-group">
        <label for="staff_id">Staff ID</label>
        <input type="text" id="staff_id" name="staff_id" required>
    </div>
    <div class="form-group">
        <label for="amount">Amount (RM)</label>
        <input type="number" id="amount" name="amount" step="0.01" required>
    </div>
    <button type="submit" name="submit" class="btn">Process</button>
</form>

    </div>
</body>
</html>