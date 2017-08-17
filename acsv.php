<?php
session_start();

$fileName = 'tweets.csv';
$_SESSION['$fetching_tweet_arr'] = $_POST['$fetching_tweet_arr'];
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Description: File Transfer');
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename={$fileName}");
header("Expires: 0");
header("Pragma: public");

$fh = @fopen( 'php://output', 'w' );

$headerDisplayed = false;

foreach ($fetching_tweet_arr as $data ) {

    if ( !$headerDisplayed ) {

        fputcsv($fh, array_keys($data));
        $headerDisplayed = true;
    }
 
    fputcsv($fh, $data);
}

fclose($fh);

exit;

?>