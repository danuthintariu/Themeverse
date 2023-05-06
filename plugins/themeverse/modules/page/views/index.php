<?/***
Themeverse - by Danut Hintariu https://github.com/danuthintariu
Version 1.0.4
-------------------------------
//////Tested for versions//////
---------------------
Rukovoditel -> 3.3.1
Extension   -> 3.3.1
-------------------------------
***/
   // Version check on github
   $usernames = "danuthintariu";
   $repos = "Themeverse";
   $paths = "plugins/themeverse/modules/page/views/index.php";

   $url_git_th = "https://api.github.com/repos/$usernames/$repos/contents/$paths";
   $optionsq = array(
     'http' => array(
      'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n" . 
                  "Accept: application/vnd.github.v3+json\r\n"
       )
     );

          $contextq = stream_context_create($optionsq);
          $responseq = file_get_contents($url_git_th, false, $contextq);
          $dataz = json_decode($responseq);

          $content_th = base64_decode($dataz->content);
          $lines_th = explode("\n", $content_th);

          $version_th_git = null;
          foreach ($lines_th as $line_th)
           {
            if (strpos($line_th, 'Version ') === 0)
             {
              $version_th_git = trim(substr($line_th, 8));
              break;
             }
           }



            // Check themeverse version installed on the server
            $filename_th = $_SERVER['DOCUMENT_ROOT'] . '/plugins/themeverse/modules/page/views/index.php';
            $version_pattern_th = '/Version\s*(\d+\.\d+\.\d+)/i'; // regular expression to search for version in X.Y.Z format
            $result_th = "";         
           if (file_exists($filename_th))
           {
            $content_dir_th = file_get_contents($filename_th);
            if (preg_match($version_pattern_th, $content_dir_th, $matches_th))
             {
              $version_th = $matches_th[1];
              // Displays the current version of the intex.php file on server behind the title only (so this is left blank no point to be double displayed)
              $result_th = "";
             }
            else
             {
              // Display if the line with version in the intex.php file could not be found
              $result_th = TEXT_PLUGIN_CHECK_VFS . " $filename_th";
             }
           }
          else
           {
            // Display if the index.php file could not be found in the folder
            $result_th = TEXT_PLUGIN_FILE_CK . " $filename_th " . TEXT_PLUGIN_FILE_CKC;
           }


$result_th_final = "";
if ($version_th_git === $version_th)
       {
         $result_th_final = $result_th;
       }
       else
       {
         $result_th_final = "<font color='red'>".TEXT_PLUGIN_GIT_NEW." $version_th_git</font>";
       }

?>

<!-- Display the name of plugin and the version behind -->
<h1 class="page-title"><?php echo TEXT_PLUGIN_TITLE." $version_th";?></h1>
<!-- Display if any new version is found on GitHub or any error occure -->
<p><?php echo $result_th_final;?></p>

<?php
echo '<hr>';

echo user_class::get_user_info();

echo '<hr>';

// The path to skins on the local server
$dir = $_SERVER['DOCUMENT_ROOT'] . '/css/skins';

// Browse all directories in the specified path
$found_skin = false; // Initially no skin was found with the word "Themeverse" on line 2 of the CSS file
$files = scandir($dir);
foreach ($files as $file1)
 {
  // Check if it is a valid directory
  if ($file1 != '.' && $file1 != '..' && is_dir($dir . '/' . $file1))
   {
    // Checks if the directory contains a CSS file with the same name
    if (file_exists($dir . '/' . $file1 . '/' . $file1 . '.css'))
     {
      // Open the CSS file and read the second line
      $css_files = fopen($dir . '/' . $file1 . '/' . $file1 . '.css', 'r');
      $line_file = fgets($css_files);
      $line_file = fgets($css_files);
      if (strpos($line_file, 'Themeverse') !== false) // The word we were looking for on line 2
       {
        // The word "Themeverse" was found on line 2 of the CSS file
        // Set the variable $result_path_file with the path to the CSS file
        $result_path_file = $dir . '/' . $file1 . '/' . $file1 . '.css';     //for .css
        $result_path_img = $dir . '/' . $file1 . '/' . $file1 . '.png';      //for image
        $found_skin = true; // Found at least one skin with the word "Themeverse" on line 2 of the CSS file
        $name_skin = $file1;

        // Show Skin Data
        if ($found_skin)
         {
          $url_dir = $result_path_file;
          // We get the filename and directory from the full path
          $filename_file = basename($url_dir);
          $dirname = basename(dirname($url_dir));
          // We get the position of the /css/skins directory in the URL
          $pos = strpos($url_dir, '/css/skins');
          if ($pos !== false)
           {
            // We get the path relative to the /css/skins directory
            $relative_path = substr($url_dir, $pos + strlen('/css/skins'));
            // We display the relative path along with the directory and file name
            // $result_url_dir = $dirname . $relative_path . '/' . $filename_file;
            
           }

          // Check skin version installed on the server
          $filename = $result_path_file;
          $version_pattern = '/Version\s*(\d+\.\d+\.\d+)/i'; // regular expression to search for version in X.Y.Z format
          $result = "";

          if (file_exists($filename))
           {
            $content_dir = file_get_contents($filename);
            if (preg_match($version_pattern, $content_dir, $matches))
             {
              $version = $matches[1];
              // Displays the current version of the .css file on server
              $result = TEXT_PLUGIN_LATEST . ": $version";
             }
            else
             {
              // Display if the line with version in the .css file could not be found
              $result = TEXT_PLUGIN_CHECK_VFS . " $filename";
             }
           }
          else
           {
            // Display if the .css file could not be found in the folder
            $result = TEXT_PLUGIN_FILE_CK . " $filename " . TEXT_PLUGIN_FILE_CKC;
           }

   // Version check on github
   $username = "danuthintariu";
   $repo = "Themeverse";
   $path = "css/skins" . $relative_path;

   $url_git = "https://api.github.com/repos/$username/$repo/contents/$path";
   $options = array(
     'http' => array(
      'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n" . 
                  "Accept: application/vnd.github.v3+json\r\n"
       )
     );

          $context = stream_context_create($options);
          $response = file_get_contents($url_git, false, $context);
          $data = json_decode($response);

          $content = base64_decode($data->content);
          $lines = explode("\n", $content);

          $version_git = null;
          foreach ($lines as $line)
           {
            if (strpos($line, 'Version ') === 0)
             {
              $version_git = trim(substr($line, 8));
              break;
             }
           }

          echo '<div class="panel panel-default" style="max-width: 300px; width:100%; float: left; margin-right: 20px;">';

          echo '<div class="panel-heading">';
          echo $name_skin; // Display the title of the skin found on the server
          echo '</div>';

          echo '<div class="panel-body">';
          // Display the skin image centered in the middle
          echo '<img src="../../../../css/skins/'. $name_skin .'/'. $name_skin.'.png" style="display: block; margin: 0 auto; width: 80px; height: 80px;"></br>';

          if ($version_git === $version)
           {
            // Display the newest version or error if skin exist and are any problems
            echo "$result</br>";
            // Display the current version on GitHub
            echo TEXT_PLUGIN_GIT_CUR.": $version_git";
           }
          else
           {

            if ($version_git === null)
             {
              // Display the current version on server
              echo TEXT_PLUGIN_CURRENT.": $version</br>";
              // Message displayed if the skin is not found on github
              echo "<font color='red'>".TEXT_PLUGIN_GIT_NO."</font>";  
             }
            else
             {
              // Display the current version on server
              echo TEXT_PLUGIN_CURRENT.": $version</br>";
              // Display in red if there is a newer version available on github
              echo "<font color='red'>".TEXT_PLUGIN_NEW.": $version_git</font>";
             }
           }

          echo '</div>';
          echo '</div>';

         }
        else
         {
          // Display this message if no Themeverse skin installed was found on server
          echo TEXT_PLUGIN_NO_FILE. "$dir";

         }

       }
      fclose($css_files);
     }
   }
 }

