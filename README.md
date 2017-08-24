# Twitter_Challenge_rtCamp
This is an assignment of the company rtCamp used to test the skills of candidates.

The repository consists of 4 php files which includes
1. index.php - It will be the first file that will be executed on the server. It will show the webpage which will ask the user to login to the twitter. It will use the twitter oAuth API for authentication and accessing the token for authentic login into twitter. After successfull login user will be again redirected to th same index.php file with session andslider.php file included in it. It will fetch the top 10 tweets of the users including all of their followers.

2. slider.php - This file is included in the index.php and the sesion will exist. Now this has a jQuery slider which will show the top 10 tweets of the user in it and below that it will show the list of all the followers of that logged in user. It will also contain search.php in it that will be used to search amongst the followers of the user with the help of AJAX so without refreshing the page the followers can be searched.
It is conataining a downlaod button as .csv to download the tweets inn a .csv file format. By clicking on the button it will redirect to the acsv.php page.

3. search.php - This will contain the searching logic used in AJAX for the followers of the logged in user.

4. acsv.php - It will contain the logic of how to get the tweets of the logged in user and it will downaload the tweets in a .csv file format.
