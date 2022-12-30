<html>
<body>  
<head>     
   <?php
        include 'inc/function.php';
        
        $pageTitle = "Personal Media Library";
        $section = null;

        include 'inc/header.php';
    ?>
    <div class="content">
        <div class="section catalog random">
            <div class="wrapper">
                <h2>May we suggest something?</h2>
                <ul class="items">
                    <?php
                        $random = random_catalog_array();
                        foreach ($random as $item) {
                            echo get_item_html($item);
                        }
                    ?>
                </ul>
            </div>    
        </div>
    </div>

    <?php include 'inc/footer.php' ?>
</head>    
</body>
</html>