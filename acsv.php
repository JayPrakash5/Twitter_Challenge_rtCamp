<?php

session_start();
$fetching_tweet_arr[] = $_SESSION['tweets_arr'];

$fileName = 'tweets.csv';
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Description: File Transfer');
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename={$fileName}");
header("Expires: 0");
header("Pragma: public");

$fh = @fopen( 'php://output', 'w' );

$headerDisplayed = false;

foreach ($fetching_tweet_arr as $data ) {
    /*if ( !$headerDisplayed ) {

        fputcsv($fh, array_keys($data),"\n");
        $headerDisplayed = true;
    }*/
    fputcsv($fh, $data,"\n");
}

fclose($fh);

exit;

?>
