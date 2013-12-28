<?php

// include the Rackspace Cloud files PHP API
require('cloudfiles.php');
 
if(count($_POST) > 0) {
    $rackspace_user = "kunalexuberant"; // this is your rackspace user name
    $rackspace_api_key = "08e53e9faf3013004eb92dc00611e690"; // get it from my account tab
     
    // Lets connect to Rackspace
    $authentication = new CF_Authentication($rackspace_user, $rackspace_api_key);
    $authentication->authenticate();
    $connection = null;
    try {
        $connection = new CF_Connection($authentication);    
    }
    catch(AuthenticationException $e) {
        echo "Unable to authenticate ".$e->getMessage();
        die(0);
    }
    
    $container = null;  
    // create a new container if you like uncomment the line below 
    // $container = new CF_Container($authentication,$connection,"testcontainer"); 
    // Or use an already exsting container
    // $container = $connection->get_container('testcontainer');
    // or better way to handle this according to me is
    try
    {
        $container = $connection->get_container('photo');
        $container->make_public();
    }
    catch(NoSuchContainerException $e) {
       $container= $connection->create_container('photo');
    }
    catch(InvalidResponseException $res) {
        // let your users know or try again or just store the file locally and try again later to push it to the Cloud
    }
     
    // store file information
    $file_to_be_uploaded = $_FILES['to_be_uploaded_file']['tmp_name'];
	require_once('../include/Help.php');
	$help = new Help();
    $filename = $help->image_name();
     
    // upload file to Rackspace
    $object = $container->create_object($filename);
    $object->load_from_filename($file_to_be_uploaded);
    echo $object->public_uri();
    // thats it you are done.
}
?>

<form action="uploader.php" enctype="multipart/form-data" method="POST">
    Select a File: <input name="to_be_uploaded_file" type="file" /> <br/>
    <input name="submit" type="submit" value="Send to Rackspace Cloud Files!" />
</form>
