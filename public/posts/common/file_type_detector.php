<?php

function isImageOrVideo($filePath) {
  $finfo = finfo_open(FILEINFO_MIME_TYPE); 
  $mimeType = finfo_file($finfo, $filePath);
  finfo_close($finfo);

  $imageMimes = [
    'image/jpeg', 
    'image/png', 
    'image/gif', 
    // Add more image MIME types as needed
  ];

  $videoMimes = [
    'video/mp4', 
    'video/webm', 
    'video/mpeg', 
    // Add more video MIME types as needed
  ];

  if (in_array($mimeType, $imageMimes)) {
    return 'image';
  } elseif (in_array($mimeType, $videoMimes)) {
    return 'video';
  } else {
    return 'unknown'; 
  }
}