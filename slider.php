<html>
    <head>
        <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
<style> 
input[type=text] {
    width: 130px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-image: url('searchicon.png');
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
}

input[type=text]:focus {
    width: 100%;
}
</style>
</head>
    
    <body>
        <?php
           $fetching_tweet_arr[] = $_SESSION['tweets_arr'];
           $fetching_user_names_arr[] = $_SESSION['user_name_arr'];
           $fetching_followers_arr[] = $_SESSION['followers_ayy'];
        ?>

       <br>
       <hr width="100%" size="5" style="background-color: black";>
       <p class="fontstyle" style="color:#4B0082; margin:10px;" align="center">Top 10 Tweets</p>
       <hr width="100%" size="5" style="background-color: black;">
       <div align="center">
       <div class="autoplay" style="width:75%; border-style:inset; border-width:10px; border-color:#91A3B0;">
           <?php
           $index=1;
            for ($i=0; $i < 10; $i++) { 
                echo '<div style="background-color:000000; color:white; height:150px; padding:10px;">';
                echo $index . ". " . $fetching_user_names_arr[0][$i] . '<br><br>';
                echo $fetching_tweet_arr[0][$i];
                echo '</div>';
                $index++;
            }
           ?>
       </div></div>


<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="slick/slick.min.js"></script>

<script type="text/javascript">
            $(document).ready(function(){
                $('.autoplay').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    });
                });
</script>
<br><br><br><br><br>
<hr width="100%" size="5" style="background-color: black;">
<div align="center">
<p class="fontstyle" style="color:#4B0082; margin:10px;">Your Followers</p>
<hr width="100%" size="5" style="background-color: black;">

<?php
$index=1;
$temp=0;
    foreach ($fetching_followers_arr as $key => $value) {
        foreach($value as $ans){
         $temp_arr[$temp] = $ans;
         $temp++;
         echo '<div style="background-color:000000; color:white; width: 300px; padding: 7px; border-style:inset; border-width:4px; border-color:#91A3B0; margin: 7px;">' . $index . '. ' . $ans . '</div>';
            $index++;
    }}  
$_SESSION["temp_search"] = $temp_arr;
?>
</div>

<br><br><br><br>
<div>
<hr width="100%" size="5" style="background-color: black;">
<div align="center">
<p class="fontstyle" style="color:#4B0082; margin:10px;">Search Your Followers</p>
<hr width="100%" size="5" style="background-color: black;">
<form>
<input type="text" name="search" onkeyup="showHint(this.value)" placeholder="Search">
</form><br>
<span id="results"></span><br><br>
<hr width="100%" size="5" style="background-color: black;">


<script>
    function showHint(str) {
        if (str.length == 0 || str == " ") {
            document.getElementById("txtHint").innnerHTML = "";
            return;
        }
        else{
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    document.getElementById("results").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "instant_search.php?q="+ str, true);
            xmlhttp.send();
        }
    }
</script>
</div>

<br><br><br><br>
<div>
<hr width="100%" size="5" style="background-color: black;">
<div align="center">
<p class="fontstyle" style="color:#4B0082; margin:10px;">Download Tweets</p>
<hr width="100%" size="5" style="background-color: black;">
<a href="acsv.php" class="button"><span>.CSV</span></a>
</div>

<br><br><br>



</body>
</html>