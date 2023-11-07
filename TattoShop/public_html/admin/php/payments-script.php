<?php
include 'db.php'; // include database connection file

// query to select payment status
$paymentStatusQuery = $dbh->query("SELECT id, status FROM payments");

// iterate over each payment
while ($row = $paymentStatusQuery->fetch(PDO::FETCH_ASSOC)) {
    $payment_id = $row['id'];
    $status = $row['status'];

    // based on status value, update the corresponding order if it's not already paid, canceled or completed
    if ($status == 1) {
        $dbh->query("UPDATE orders SET status='paid' WHERE payment_id=$payment_id AND status NOT IN ('paid', 'canceled', 'completed')");
    } elseif ($status == 0) {
        $dbh->query("UPDATE orders SET status='canceled' WHERE payment_id=$payment_id AND status NOT IN ('paid', 'canceled', 'completed')");
    }
}
?>
