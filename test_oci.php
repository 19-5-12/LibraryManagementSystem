   <?php
   echo "<pre>";
   echo "Loaded extensions:\n";
   print_r(get_loaded_extensions());
   echo "\n";
   echo "OCI8 loaded? ";
   echo extension_loaded('oci8') ? "YES" : "NO";
   echo "\n";
   ?>