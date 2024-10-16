<?php
define("GALFOLDER", "galeries");
if(isset($_GET["gal"]))
{
    $listGals = false;
    $galery = htmlspecialchars($_GET["gal"]);
    if(file_exists(GALFOLDER."/".$galery) && is_dir(GALFOLDER."/".$galery))
    {
        $images = scandir(GALFOLDER."/".$galery);
    }
    else
    {
        $error = "Ismeretlen galéria!";
    }
}
else
{
    $listGals = true;
    $galeries = scandir(GALFOLDER);
    if(count($galeries) == 0)
    {
        $error = "Jelenleg egyetlen galéria sem létezik!";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
        <title></title>
    </head>
    <body class="bg-info">
        <?php
        print("<h1 class=\"text-center\">".($listGals?"Feltöltött galériák":"$galery galéria képei")."</h1>");
        if(isset($error))
        {
            print("<h2 class=\"error\">$error</h2>");
        }
        else
        {
            define("DIV", 3);
            if($listGals)
            { 
                print("<div class=\"container\">");
                $i = 0;
                foreach ($galeries as $value)
                {
                    if(!($value != "." && $value != ".." && is_dir(GALFOLDER."/".$value)))
                    {
                        continue;
                    }
                    if($i == 0)
                    {
                        print("<div class=\"row\">");
                    }
                    print("<div class=\"col-12 col-sm-6 col-md-6 col-lg-4\"><a href=\"?gal=$value\" class=\"text-dark\"><img src=\"galery.png\"><br>$value</a></div>");
                    $i++;
                    if($i % DIV == 0)
                    {
                        print("</div>");
                        $i = 0;
                    }
                }
                if($i % DIV != 0)
                {
                    print("</div>");
                }
                print("</div>");
            }
            else
            {
                print("<div class='my-grid'>");
                $i = 0;
                foreach ($images as $value)
                {
                    if(!is_file(GALFOLDER."/".$galery."/".$value))
                    {
                        continue;
                    }
                    $mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), GALFOLDER."/".$galery."/".$value);
                    if(!in_array($mime, ["image/jpeg", "image/png"]))
                    {
                        continue;
                    }
                    print("<div class='item'><img width=\"256\" src=\"".(GALFOLDER."/".$galery."/".$value)."\"></div>");
                    $i++;
                    if($i % DIV == 0)
                    {
                        $i = 0;
                    }
                }
                print("</div>");
                echo("<script type=\"text/javascript\" src=\"js/waterfall.js\"></script>");
                echo("<script type=\"text/javascript\">
                    var grid = document.querySelector('.my-grid');
                    var gridLoad = 2;
                    window.addEventListener('resize', function () {
                        waterfall(grid);
                    });
                    for(let i = 0; i <= gridLoad; i++) {
                        waterfall(grid);
                    }
                </script>");
            }
        }
        ?>
    </body>
</html>
