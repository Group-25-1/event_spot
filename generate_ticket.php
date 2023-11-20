<?php
@include 'config.php';
require('fpdf/fpdf.php');

session_start();

if (isset($_GET['eventName'])) {
  $eventName = $_GET['eventName'];
  $_SESSION['eventName'] = $eventName;
  // Retrieve event details from the "new_event" table
$selectEvent = "SELECT date, location, time FROM new_event WHERE eventName = '$eventName'";
$result = mysqli_query($conn, $selectEvent);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $date = $row['date'];
  $location = $row['location'];
  $time = $row['time'];
  // Generate a unique code for the ticket
  $ticketCode = generateTicketCode();

  // Create a new PDF ticket
  $pdf = new FPDF();
  $pdf->AddPage();

  // Set the font style
  $pdf->SetFont('Arial', 'B', 14);

  // Add the event details to the PDF
  // Border for the ticket
  $pdf->SetLineWidth(1);
  $pdf->Rect(10, 10, 190, 80);

  // Header
  $pdf->Cell(0, 10, 'Event Ticket', 0, 1, 'C');
  $pdf->Ln(10);

  // Event Name
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 10, $eventName, 0, 1, 'C');
  $pdf->Ln(5);

  // Ticket Code
  $pdf->SetFont('Arial', '', 12);
  $pdf->Cell(0, 10, 'Ticket Code: ' . $ticketCode, 0, 1);
  $pdf->Ln(5);

  // Date, Location, Time
  $pdf->Cell(0, 10, 'Date: ' . $date, 0, 1);
  $pdf->Cell(0, 10, 'Location: ' . $location, 0, 1);
  $pdf->Cell(0, 10, 'Time: ' . $time, 0, 1);
  $pdf->Ln(10);

  // Footer
  $pdf->SetFont('Arial', 'I', 8);
  $pdf->Cell(0, 10, 'This ticket is non-transferable and valid only for the specified event.', 0, 1, 'C');

  // Output the PDF
  $pdf->Output();

} else {
  echo "Event details not found in the database.";
  exit;
}
} else {
  echo "Event name not found in session.";
  exit;
}



  

// Function to generate a unique ticket code
function generateTicketCode() {
  // Generate a random alphanumeric code
  $code = '';
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $codeLength = 8;

  for ($i = 0; $i < $codeLength; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $code .= $characters[$index];
  }

  return $code;
}