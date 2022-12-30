<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="header">
        <div class="wrapper">
            <h1 class="branding-title"><a href="#">Personal Media Library</a></h1>
            <ul class="nav">
                <li class="books <?php if($section == "books") { echo " on"; } ?>"><a href="catalog.php?cat=books">Books</a></li>
                <li class="movies <?php if($section == "movies") { echo " on"; } ?>"><a href="catalog.php?cat=movies">Movies</a></li>
                <li class="music <?php if($section == "music") { echo " on"; } ?>"><a href="catalog.php?cat=music">Music</a></li>
                <li class="suggest <?php if($section == "suggest") { echo " on"; } ?>"><a href="suggest.php">Suggest</a></li>
            </ul>   
        </div>
    </div>
    <div class="search" style="float: right;">
		<!-- action attribute defines the destination where the form data will be submitted  -->
		<!-- we can specify a web address here, but if we leave it blank, the form will submit back to the current page -->
		<!-- method attribute defines the request method used on the next request that includes the submitted form data -->
		<!-- two possible values are get and post , default value is get -->
			<form method="get" action="catalog.php" style="margin: 10px 0px; width: 100%;">
				<!-- Inside the form tag, we need two elements, a text field to enter the search term and 
	    a submit button to send the search term to the server  -->
	
			<label for="s">Search:</label>
			<input type="text" name="s" id="s">
			<input type="submit" value="go" style="width: 25px; padding: 3px 0px">
		</form>
	</div>
    