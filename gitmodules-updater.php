<?php

function gitmodules_get_all($dir){
  $contents = explode("\n", file_get_contents($dir . '/.gitmodules'));

  $submodules = array();

  for($i = 0; $i < count($contents); $i++){
    $line = $contents[$i];
      
    if(($submodule_name = gitmodules_get_name($line))){
      $submodule_path = gitmodules_get_path($contents[++$i]);
      $submodule_url = gitmodules_get_url($contents[++$i]);
        
      $submodule_author = gitmodules_get_author($submodule_url);
      $submodule_repo = gitmodules_get_repo($submodule_url);

      $submodule = new stdClass;
      
      $submodule->name = $submodule_name;
      $submodule->path = $submodule_path;
      $submodule->url = $submodule_url;
      $submodule->author = $submodule_author;
      $submodule->repo = $submodule_repo;
      
      $submodule->is_github = strpos($submodule->url, '://github.com') !== FALSE;

      $submodules[] = $submodule;
    }
  }

  return $submodules;
}

function gitmodules_get_by_name($name){
  $submodules = gitmodules_get_all();

  foreach($submodules as $submodule){
    if($submodule->name == $name){
      return $submodule;
    }
  }

  return NULL;
}

function gitmodules_get_name($line){
  if(preg_match('@\[submodule "([^"]+)"\]@', $line, $matches)){
    return $matches[1];
  } else {
    return FALSE;
  }
}

function gitmodules_get_path($line){
  if(preg_match('@\s+path\s+=\s+(.+)@', $line, $matches)){
    return $matches[1];
  } else {
    return FALSE;
  }
}

function gitmodules_get_url($line){
  if(preg_match('@\s+url\s+=\s+(.+)@', $line, $matches)){
    return $matches[1];
  } else {
    return FALSE;
  }
}

function gitmodules_get_author($submodule_url){
  if(preg_match('@://github.com/([^/]+)/@', $submodule_url, $matches)){
    return $matches[1];
  } else {
    return FALSE;
  }
}

function gitmodules_get_repo($submodule_url){
  if(preg_match('@://github.com/[^/]+/([^.]+)\.git@', $submodule_url, $matches)){
    return $matches[1];
  } else {
    return FALSE;
  }
}