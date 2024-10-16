<?php
define("GALFOLDER", "galeries");
if(isset($_POST["ok"]))
{
    if(isset($_POST["galName"]) && trim($_POST["galName"]) != "")
    {
        $galName = htmlspecialchars($_POST["galName"]);
        mkdir(GALFOLDER."/".$galName, 644);
        //print(fileperms(GALFOLDER."/".$galName));
        if(file_exists(GALFOLDER."/".$galName) /*&& fileperms(GALFOLDER."/".$galName) == 644*/)
        {
            $result["success"] = true;
            $result["info"] = "Az új galéria létrejött!";
        }
        else
        {
            $result["success"] = false;
            $result["info"] = "Az új galéria létrehozása sikertelen!";
        }
    }
    else
    {
        $result["success"] = false;
        $result["info"] = "Hibás galéria név!";
    }
}
if(isset($_POST["upload"]))
{
    if(isset($_POST["galery"]) && file_exists(GALFOLDER."/".$_POST["galery"]) && is_dir(GALFOLDER."/".$_POST["galery"]))
    {
        $galery = htmlspecialchars($_POST["galery"]);
        //$_FILES["images"]["..."][index]
        if(isset($_FILES["images"]))
        {
            if(count($_FILES["images"]["tmp_name"]) > 0)
            {
                for($i = 0; $i < count($_FILES["images"]["tmp_name"]); $i++)
                {
                    if($_FILES["images"]["error"][$i] == 0)
                    {
                        $mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES["images"]["tmp_name"][$i]);
                        if(in_array($mime, ["image/jpeg", "image/png"]))
                        {
                            if(move_uploaded_file($_FILES["images"]["tmp_name"][$i], GALFOLDER."/".$galery."/". basename($_FILES["images"]["name"][$i])))
                            {
                                $result["files"][$i]["success"] = true;
                                $result["files"][$i]["info"] = "A(z) ".basename($_FILES["images"]["name"][$i])." kép feltöltése sikeres!";
                            }
                            else
                            {
                                $result["files"][$i]["success"] = false;
                                $result["files"][$i]["info"] = "A(z) ".basename($_FILES["images"]["name"][$i])." kép feltöltése meghiúsult!";
                            }
                        }
                        else
                        {
                            $result["files"][$i]["success"] = false;
                            $result["files"][$i]["info"] = "A(z) ".basename($_FILES["images"]["name"][$i])." fájl típusa nem megfelelő!";
                        }
                    }
                    else
                    {
                        $result["files"][$i]["success"] = false;
                        $result["files"][$i]["info"] = "A(z) ".basename($_FILES["images"]["name"][$i])." fájl feltöltése sikertelen!";
                    }
                }
                $result["success"] = true;
                $result["info"] = "A képek feltöltése lezárult!";
            }
            else
            {
                $result["success"] = false;
                $result["info"] = "Nincs feltöltendő kép!";
            }
        }
        else
        {
            $result["success"] = false;
            $result["info"] = "Nem érkezett fájl a hívás során!";
        }
    }
    else
    {
        $result["success"] = false;
        $result["info"] = "Nem került definiálásra galéria!";
    }
}
// Galéria vagy kép törölése
if(isset($_POST["delete"]))
{
    if(isset($_POST["galOrImgName"]) && trim($_POST["galOrImgName"]) != "")
    {
        $galOrImgName = htmlspecialchars($_POST["galOrImgName"]);
        rmdir(GALFOLDER."/".$galOrImgName);
        $galeries = scandir(GALFOLDER);
        if($galeries != "." && $galeries != "..")
        {
            foreach ($galeries as $value) 
            {
                unlink(GALFOLDER."/".$value."/".$galOrImgName);
                if ($value == $galOrImgName)
                {
                    array_map('unlink', glob(GALFOLDER."/".$value."/*"));
                    rmdir(GALFOLDER."/".$value);
                }
            }
        }
        if(file_exists(GALFOLDER."/".$galOrImgName))
        {
            $result["success"] = true;
            $result["info"] = "A galéria vagy kép törölve!";
        }
        else
        {
            $result["success"] = false;
            $result["info"] = "A galéria vagy kép nem létezik!";
        }
    }
    else
    {
        $result["success"] = false;
        $result["info"] = "Hibás galéria vagy kép név!";
    }
}
//Galériák begyűjtése
$dir = opendir(GALFOLDER);
$galeries = array();
if($dir !== false)
{
    while(($gal = readdir($dir)) !== false)
    {
        if($gal != "." && $gal != ".." && is_dir(GALFOLDER."/".$gal))
        {
            $galeries[] = $gal;
        }
    }
    closedir($dir);
}
//Képek begyűjtése
$dir = opendir(GALFOLDER);
$images = array();
if($dir !== false)
{
    while(($mappa = readdir($dir)) !== false)
    {
        if($mappa != "." && $mappa != ".." && finfo_file(finfo_open(FILEINFO_MIME_TYPE), GALFOLDER."/".$img))
        {
            if($img_azon = opendir("./galeries/$mappa")) 
            {
                while (false !== ($img = readdir($img_azon))) 
                {
                    if($img != "." && $img !== "..") 
                    {
                        $images[] = $img;
                    }
                }
            }
        }
    }
    closedir($dir);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <script src="https://kit.fontawesome.com/05551fc6ea.js" crossorigin="anonymous"></script>
        <title></title>
    </head>
    <body>
        <?php
        if(isset($result))
        {
            print("<p class=\"".($result["success"]?"success":"error")."\">{$result["info"]}</p>");
            if($result["success"] && isset($result["files"]))
            {
                print("<p>A feltöltés részletei:<ul>");
                foreach($result["files"] as $finfo)
                {
                    print("<li class=\"".($finfo["success"]?"success":"error")."\">{$finfo["info"]}</li>");
                }
                print("</ul></p>");
            }
        }
        ?>
        <h2 class="text-center">Galéria létrehozása</h2>
        <form method="post">
            <label for="galName" class="form-label">Galéria neve:</label>
            <input type="text" name="galName" id="galName" placeholder="Galéria neve" class="form-control-lg form-control form-control-sm"><br>
            <input type="submit" name="ok" value="Létrehozás" class="border-dark shadow bg-primary text-white form-control-lg form-control form-control-sm mt-1">
        </form>
        <hr>
        <h2 class="text-center">Képek feltöltése</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="images" class="form-label">Képek:</label>
            <input type="file" name="images[]" id="images" multiple accept="image/jpeg, image/png" class="form-control-lg form-control form-control-sm"><br>
            <label for="galery" class="form-label">Galéria, ahova a képek feltöltésre kerülnek:</label>
            <select name="galery" id="galery" class="form-control-lg form-control form-control-sm">
                <?php
                foreach ($galeries as $value)
                {
                    print("<option id=\"$value\">$value</option>");
                }
                ?>
            </select><br>
            <input type="submit" name="upload" value="Feltöltés" class="border-dark shadow bg-primary text-white form-control-lg form-control form-control-sm mt-1">
        </form>
        <hr>
        <h2 class="text-center bg-info mb-0 pb-2">Garélia és képek listái</h2>
        <table width="100%" class="bg-info">
            <tr>
                <td>
                    <ul>
                        <?php
                            foreach ($galeries as $value)
                            {
                                print("
                                <li id=\"$value\">
                                    <form method=\"post\">
                                        $value
                                        <input type=\"hidden\" name=\"galOrImgName\" id=\"galOrImgName\" value=\"$value\">
                                        <button type=\"submit\" name=\"delete\"><i class=\"fa fa-trash\"></i></button>
                                    </form>
                                </li>
                                ");
                            }
                        ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                            foreach ($images as $value)
                            {
                                print("
                                <li id=\"$value\">
                                    <form method=\"post\">
                                        $value
                                        <input type=\"hidden\" name=\"galOrImgName\" id=\"galOrImgName\" value=\"$value\">
                                        <button type=\"submit\" name=\"delete\"><i class=\"fa fa-trash\"></i></button>
                                    </form>
                                </li>
                                ");
                            }
                        ?>
                    </ul>
                </td>
            </tr>
        </table>
        <hr>
    </body>
</html>