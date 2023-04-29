<h1 class="page-title"><?php
/**
* Class and Function List:
* Function list:
* Classes list:
*/
echo TEXT_PLUGIN_TITLE ?> </h1>

<?php
echo '<hr>';

echo user_class::get_user_info();

echo '<hr>';

//Calea catre skinuri
$dir = $_SERVER['DOCUMENT_ROOT'] . '/css/skins';

// Parcurge toate directoarele din calea specificată
$found_skin = false; // Inițial nu s-a găsit niciun skin cu cuvântul "Themeverse" pe linia 2 a fișierului CSS
$files = scandir($dir);
foreach ($files as $file1)
 {
  // Verifică dacă este un director valid
  if ($file1 != '.' && $file1 != '..' && is_dir($dir . '/' . $file1))
   {
    // Verifică dacă directorul conține un fișier CSS cu același nume
    if (file_exists($dir . '/' . $file1 . '/' . $file1 . '.css'))
     {
      // Deschide fișierul CSS și citește linia a treia
      $css_files = fopen($dir . '/' . $file1 . '/' . $file1 . '.css', 'r');
      $line_file = fgets($css_files);
      $line_file = fgets($css_files);
      if (strpos($line_file, 'Themeverse') !== false)
       {
        // Cuvântul "Themeverse" a fost găsit pe linia 2 a fișierului CSS
        // Setează variabila $result_path_file cu calea către fișierul CSS
        $result_path_file = $dir . '/' . $file1 . '/' . $file1 . '.css'; //pentru .css
        $result_path_img = $dir . '/' . $file1 . '/' . $file1 . '.png'; //pentru imagine
        $found_skin = true; // A fost găsit cel puțin un skin cu cuvântul "Themeverse" pe linia 2 a fișierului CSS
        $name_skin = $file1;

        // Afișează Datele despre skin
        if ($found_skin)
         {
          $url_dir = $result_path_file;
          // Obținem numele fișierului și directorului din calea completă
          $filename_file = basename($url_dir);
          $dirname = basename(dirname($url_dir));
          // Obținem poziția directorului /css/skins în URL
          $pos = strpos($url_dir, '/css/skins');
          if ($pos !== false)
           {
            // Obținem calea relativă la directorul /css/skins
            $relative_path = substr($url_dir, $pos + strlen('/css/skins'));
            // Afișăm calea relativă, împreună cu numele directorului și fișierului
            //$result_url_dir = $dirname . $relative_path . '/' . $filename_file;
            
           }

          // Verificare versiune skin pe server
          $filename = $result_path_file;
          $version_pattern = '/Version\s*(\d+\.\d+\.\d+)/i'; // expresie regulată pentru a căuta versiunea în formatul X.Y.Z
          $result = "";

          if (file_exists($filename))
           {
            $content_dir = file_get_contents($filename);
            if (preg_match($version_pattern, $content_dir, $matches))
             {
              $version = $matches[1];
              // Afiseaza versiunea curenta a fisierului css
              $result = TEXT_PLUGIN_LATEST . ": $version";
             }
            else
             {
              //Afiseaza daca nu sa putut gasi versiunea in fisierul css
              $result = TEXT_PLUGIN_CHECK_VFS . " $filename";
             }
           }
          else
           {
            //Afiseaza daca fisierul css nu a putut fi gasit in folder
            $result = TEXT_PLUGIN_FILE_CK . " $filename " . TEXT_PLUGIN_FILE_CKC;
           }

   // verificare versiune pe git
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
          echo $name_skin;
          echo '</div>';

          echo '<div class="panel-body">';
          echo '<img src="../../../../css/skins/'. $name_skin .'/'. $name_skin.'.png" style="display: block; margin: 0 auto; width: 80px; height: 80px;"></br>';

          if ($version_git === $version)
           {
            // Afiseaza versiunea cea mai noua de pe git
            echo $result;
           }
          else
           {

            if ($version_git === null)
             {
              // Mesaj afisat daca nu este gasita versiune pe git.
              echo "<font color='red'>Nu a fost gasit pe git aceast skin</font></br>";
              // Afiseaza versiunea curenta pe server
              echo TEXT_PLUGIN_CURRENT . ": $version";
             }
            else
             {
              // Afiseaza cu rosu daca este o versiune mai noua pe git si numarul ei
              echo "<font color='red'>" . TEXT_PLUGIN_NEW . ": $version_git</font></br>";
              // Afiseaza versiunea curenta pe server
              echo TEXT_PLUGIN_CURRENT . ": $version";
             }
           }

          echo '</div>';
          echo '</div>';

         }
        else
         {

          echo "Nu a fost găsit niciun skin instalat Themeverse in directorul $dir";

         }

       }
      fclose($css_files);
     }
   }
 }

