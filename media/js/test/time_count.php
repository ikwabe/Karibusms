<!DOCTYPE html>
<head>

    <script type="text/javascript" src="jquery-1.7.2.min.js"></script>

</head>

<body >

    <div id="time_count"></div>
    <script type="text/javascript">
        time_count = function() {
            var d = new Date();
            $('#time_count').html(d.toLocaleTimeString());
        };
        var myVar = setInterval(function() {
           time_count()
        }, 1000);
        $(document).ready(time_count);
    </script>
    
    
    <?php
    
    //this is the script to show image from a database
    
    /**
     * steps to follow
     * 
     * 1. upload image in normal way to a folder example  media/images/myprofilepic.png
     * 2. Take the path of this image and store it in a database. Forexample
     *        in above upload, my path will be  media/images/myprofilepic.png
     *       
     *      Assume your database table is called "user" and a column which you store image is
     *      called "profile_pic", with that a column "profile_pic" will be varchar and you will
     *       store a value "media/images/myprofilepic.png" path
     * 
     * 3. Now perform database query as follows
     * 
     */
    $query=  mysql_query("SELECT profile_pic FROM user WHERE id='2' ");
    while ($row = mysql_fetch_array($query)) {
        $image_src=$row['profile_pic']; // this will return 'media/images/myprofilepic.png'
       
        $image_to_display="<img src=".$image_src." />";
    }
    
    // if you echo $image_to_display varible it will give you an image view
    echo $image_to_display;
    
    ?>
</body> 
</html>