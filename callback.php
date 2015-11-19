<script type="text/javascript">
window.location = "display.php";
</script>
<?php
echo "<center><img width='500px' src='layouts/images/shared/logo.png'></center>";

include 'google_drive_header.php';
include 'classes/dashboard.class.php';
include 'includes/headerT.php';

class GooglDriveUpload {

    function athentication($authCode) {
        global $client;
        $accessToken = $client->authenticate($authCode);
        $client->setAccessToken($accessToken);
    }

    /**
     * Permanently delete a file, skipping the trash.
     *
     * @param Google_DriveService $service Drive API service instance.
     * @param String $fileId ID of the file to delete.
     */
    function deleteFile($service, $fileId) {
        try {
            $service->files->delete($fileId);
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
    }

    function upload($sDir, $oFile) {

        global $client;
        $sPath = $sDir . '/' . $oFile;
        $file = new Google_Service_Drive_DriveFile();
        $aFile = explode('.', $oFile);
        //$file->setTitle(@$aFile[0]);
	$file->setTitle(@$oFile);
        $file->setDescription('Video file');
        $file->setMimeType('video/mp4');

        $data = file_get_contents($sPath);
        $service = new Google_Service_Drive($client);
        $createdFile = $service->files->insert($file, array(
            'data' => $data,
            'mimeType' => 'video/mp4',
            'uploadType' => 'multipart',
        ));
// print_r($createdFile);
    }

    function createFolder($service, $title, $description, $parentId, $mimeType) {
        // global $service;
        $file = new Google_Service_Drive_DriveFile();
        $file->setTitle($title);
        $file->setDescription($description);
        $file->setMimeType($mimeType);

        try {
            $createdFile = $service->files->insert($file, array(
                'mimeType' => $mimeType,
            ));

// Uncomment the following line to print the File ID
// print 'File ID: %s' % $createdFile->getId();

            return $createdFile->getId();
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
    }

    function insertFile($sDir, $oFile, $service, $description, $parentId, $mimeType) {

        global $client;
        $sPath = $sDir . '/' . $oFile;
        $file = new Google_Service_Drive_DriveFile();
        $aFile = explode('.', $oFile);
        //$file->setTitle(@$aFile[0]);
	$file->setTitle(@$oFile);
        $file->setDescription($description);
        $file->setMimeType($mimeType);

// Set the parent folder.
        if ($parentId != null) {
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
        }

        try {
            $data = file_get_contents($sPath);

            $createdFile = $service->files->insert($file, array(
                'data' => $data,
                'mimeType' => $mimeType,
                'uploadType' => 'multipart',
            ));

// Uncomment the following line to print the File ID
// print 'File ID: %s' % $createdFile->getId();

            return $createdFile->getId();
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
    }

}

$oUpload = new GooglDriveUpload();

$oDashBoard = new Dashboard();
$aGoogleFolders = $oDashBoard->getGoogleFolderNames();
$aGFNames = array();
foreach ($aGoogleFolders as $sGoogleFolders) {
    array_push($aGFNames, $sGoogleFolders['folder_name_box_id']);
}
//echo "HAI";
//print_r($_GET);
//$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
//$txt = "Mahendra\n";
//fwrite($myfile, $txt);
//fclose($myfile);

$oUpload->athentication($_GET['code']);
global $client;
//$service = new Google_DriveService($client);
//global $service;
$service = new Google_Service_Drive($client);
$dir = "uploads";
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
//echo "filename: ." . $file . "<br />";
// echo '---'.$file.'---<br>';
            if ($file != '.' && $file != '..') {
//$oUpload->upload($dir, $file);
                $mimeType = 'video/mp4';
                $description = 'This file is uploaded by Customer';
                $parentId = '';
// echo "sndvjdfj----";
                $sContent = file_get_contents('device_ooh.txt');
                $aDeviceNames = explode(' ', $sContent);
                foreach ($aDeviceNames as $sDeviceName) {
                    $sDeviceName = trim($sDeviceName);
                    if ($sDeviceName != '') {
                        if (in_array($sDeviceName, $aGFNames)) {
                            $sGoogleFolderID = $oDashBoard->getGoogleFolderIDByName($sDeviceName);
                            $parentId = $sGoogleFolderID['google_folder_id'];
                            $sFileId = $oUpload->insertFile($dir, $file, $service, $description, $parentId, $mimeType);
                            $aFile = explode('.', $file);
                            $oDashBoard->insertGoogleFileDetails($parentId, $file, $sFileId);
                        } else {
                            $title = $sDeviceName;
                            $description = 'This Google Folder for Device ';
                            $parentId = '';
                            $mimeType = 'application/vnd.google-apps.folder';
                            $sFolderId = $oUpload->createFolder($service, $title, $description, $parentId, $mimeType);
                            $oDashBoard->insertGoogleFolderDetails($sDeviceName, $sFolderId);
                            $mimeType = 'video/mp4';
                            $description = 'This file is uploaded by Customer';
                            $parentId = $sFolderId;
                            $sFileId = $oUpload->insertFile($dir, $file, $service, $description, $parentId, $mimeType);
                            //$aFile = explode('.', $file);
			    $aFile = $file;
                            //$oDashBoard->insertGoogleFileDetails($sFolderId, $aFile[0], $sFileId);
			    $oDashBoard->insertGoogleFileDetails($sFolderId, $aFile, $sFileId);
                        }
                    }
                }
                unlink($dir . '/' . $file);
            }
        }
        closedir(@$sContent);
        closedir($dh);

        //File Deleting Process
        $sContent = file_get_contents('device_ooh.txt');
        if (strpos($sContent, '#') != false) {
            $aTemp = explode('#', $sContent);
            $aFolderD = $aTemp[0];
            $aFolderD = explode('::', $aFolderD);
            if ($aFolderD[0] == 'Folder_ID') {
                $sFolderId = $aFolderD[1];
            } else {
                $sFolderId = '';
            }
            $aFileD = $aTemp[1];
            $aFileD = explode('::', $aFileD);
            if ($aFileD[0] == 'File_ID') {
                $sFileId = $aFileD[1];
            } else {
                $sFileId = '';
            }
            if ($sFileId != '') {
                $oUpload->deleteFile($service, $sFileId);
                $oDashBoard->deleteFileById($sFileId);
            }
        }
    }
}
?>