<?php
global $wpdb;
$table = $wpdb->prefix . 'leadgen';
$results = $wpdb->get_results("SELECT * FROM $table ORDER BY submitted DESC");
echo "<h2>Collected Leads</h2><table class='widefat'><tr><th>ID</th><th>Name</th><th>Email</th><th>Submitted</th></tr>";
foreach ($results as $row) {
    echo "<tr><td>{$row->id}</td><td>{$row->name}</td><td>{$row->email}</td><td>{$row->submitted}</td></tr>";
}
echo "</table>";
?>
