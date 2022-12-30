<?php

    function get_catalog_count($category = null, $search = null){
        $category = strtolower($category);
        include 'connection.php';

        try {
            $sql = "select count(media_id) from Media ";
            if (!empty($search)) {
                //Create a PDO statement object with the SQL query we want to run
                $results = $db->prepare($sql . ' WHERE title LIKE ? ');
                $results->bindValue(1, '%' . $search . '%', PDO::PARAM_STR);
            } else if (!empty($category)) {
                $results = $db->prepare($sql . ' WHERE LOWER(category) = ? ');
                // bind our category variable to the first question mark
                $results->bindParam(1, $category, PDO::PARAM_STR);
            } else{
                $results = $db->prepare($sql);
            }
            $results->execute();
        } catch (Exception $e) {
           echo "bad query";
           echo $e->getMessage();
        }

        $count = $results->fetchColumn(0);
        return $count;
    }

    function full_catalog_array($limit = null, $offset = 0){
        include 'connection.php';
        try {
            $sql ="select media_id ,title,category,img 
                from Media
                order by 
                replace (
                    replace (
                        replace(title,'The ',''),
                    'An ',''),
                    'A ',''
                )";
            if(is_integer($limit)){
                $results = $db->prepare($sql . " LIMIT ? OFFSET ? ");
                $results->bindParam(1,$limit,PDO::PARAM_INT);
                $results->bindParam(2,$offset,PDO::PARAM_INT);
            } else{
                $results = $db->prepare($sql);
            }
            $results->execute();    
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "Unable to retrieved result";
            exit;
        }
        $catalog = $results->fetchAll();
        return $catalog;
    }

    function category_catalog_array($category, $limit = null, $offset = 0){
        $category = strtolower($category);
        include 'connection.php';
        try {
            $sql = "select media_id ,title,category,img 
                from Media
                where lower(category) = ?
                order by 
                replace (
                    replace (
                        replace(title,'The ',''),
                    'An ',''),
                    'A ',''
                )";
            if(is_integer($limit)){
                $results = $db->prepare($sql . " LIMIT ? OFFSET ? ");
                $results->bindParam(1,$category,PDO::PARAM_STR);
                $results->bindParam(2,$limit,PDO::PARAM_INT);
                $results->bindParam(3,$offset,PDO::PARAM_INT);
            } else{
                $results = $db->prepare($sql);
                $results->bindParam(1,$category,PDO::PARAM_STR);
            }
            $results->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "Unable to retrieved result";
            exit;
        }
        $catalog = $results->fetchAll();
        return $catalog;
    }

    function search_catalog_array($search, $limit = null, $offset = 0){
        include 'connection.php';
        try {
            $sql = "select media_id ,title,category,img 
                from Media
                where title like ?
                order by 
                replace (
                    replace (
                        replace(title,'The ',''),
                    'An ',''),
                    'A ',''
                )";
            if(is_integer($limit)){
                $results = $db->prepare($sql . " LIMIT ? OFFSET ?");
                $results->bindValue(1, "%" . $search . "%",PDO::PARAM_STR);
                $results->bindParam(2,$limit,PDO::PARAM_INT);
                $results->bindParam(3,$offset,PDO::PARAM_INT);
            } else{
                $results = $db->prepare($sql);
                $results->bindValue(1, "%" . $search . "%",PDO::PARAM_STR);
            }
            $results->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "Unable to retrieved result";
            exit;
        }
        $catalog = $results->fetchAll();
        return $catalog;
    }
    
    function random_catalog_array(){
        include 'connection.php';
        try {
            $results = $db->query("
            select media_id ,title,category,img 
            from Media 
            ORDER BY RANDOM() LIMIT 4
            ");
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "Unable to retrieved result";
            exit;
        }
        $catalog = $results->fetchAll();
        return $catalog;
    }

    function single_item_array($id){
        include 'connection.php';
        try {
            $results = $db->prepare(
                "select  Media.media_id,title,category,img,format,year,genre,publisher,isbn
                from Media
                join Genres on Media.genre_id = Genres.genre_id
                left outer join Books on Media.media_id = Books.media_id
                where Media.media_id = ?"
            );
            $results->bindParam(1,$id,PDO::PARAM_INT);
            $results->execute(); 
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "Unable to retrieved result";
            exit;
        }
        $item = $results->fetch();
        if(empty($item)){
            return $item;
        }

        try {
            $results = $db->prepare(
                "select fullname,role
                from Media_People
                join People on Media_People.people_id = People.people_id
                where Media_People.media_id = ?"
            );
            $results->bindParam(1,$id,PDO::PARAM_INT);
            $results->execute(); 
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "Unable to retrieved result";
            exit;
        }
        while($row = $results->fetch(PDO::FETCH_ASSOC)){
            $item[$row["role"]][] = $row["fullname"];
        }
        return $item;
    }

    function genre_array($category = null){
        $category = strtolower($category);
        include 'connection.php';

        // try {
        //     $sql = "select genre, category 
        //     from Genres 
        //     join Genre_Categories
        //     on Genres.genre_id = Genre_Categories.genre_id";
        //     if(!empty($category)) {
        //         $results = $db->prepare($sql . "where lower(category) = ? order by genre");
        //         $results->bindParam(1,$category, PDO::PARAM_STR);
        //     } else {
        //         $results = $db->prepare($sql . "ordey by genre");
        //     }
        //     $results->execute();
        // } catch (Exception $e) {
        //     echo "Bad query";
        // }
        
        try {
            $sql =
                'SELECT genre, category' .
                ' FROM Genres' .
                ' JOIN Genre_Categories ' .
                ' ON Genres.genre_id = Genre_Categories.genre_id ';
            if (!empty($category)) {
                $results = $db->prepare(
                    $sql . ' WHERE LOWER(category) = ?' . ' ORDER BY genre'
                );
                $results->bindParam(1, $category, PDO::PARAM_STR);
            } else {
                $results = $db->prepare($sql . ' ORDER BY genre');
            }
            $results->execute();
        } catch (Exception $e) {
            echo 'bad query';
            echo $e->getMessage();
        }

        $genres = [];
        while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
            $genres[$row["category"]][] = $row["genre"];
        }
        return $genres;
    }

    function get_item_html($item){
        // $output = "<li><a href='detail.php?id="
        //         .$item["media_id"] ."'> <img src='"
        //         . $item["img"] . "' alt='"
        //         . $item["title"] . "' />"
        //         . "<p>View Details</p>" 
        //         . "</a></li>";
        
        $output = "<li><a href='detail.php?id={$item["media_id"]}'> <img src='{$item["img"]}' alt='{$item["title"]}'/>"
         . "<p>View Details</p>"
         . "</a></li>";
       return $output;
    }

    function array_category($catalog,$category){
        $output = array();
        foreach ($catalog as $id => $item) {
            if($category == null OR strtolower($category) == strtolower($item["category"])){
                $sort = $item["title"];
                $sort = ltrim($sort,"The ");
                $sort = ltrim($sort,"A ");
                $sort = ltrim($sort,"An ");
                $output[$id] = $sort;
            }
        }
        asort($output);
        return array_keys($output);

    }
?>

