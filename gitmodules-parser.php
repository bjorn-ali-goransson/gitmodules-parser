<?php

function gitmodules_get_all($dir = '.'){
  $contents = explode("\n", file_get_contents($dir . '/.gitmodules'));

  $submodules = array();

  for($i = 0; $i < count($contents); $i++){
    $line = $contents[$i];
      
    if(($submodule_name = gitmodules_get_name($line))){
      
      $submodule->gitmodules_path = $gitmodules_path;

      $submodule->name = $submodule_name;
      $submodule->path = gitmodules_get_path($contents[++$i]);
      $submodule->url = gitmodules_get_url($contents[++$i]);
      
      $submodule->dir_exists = file_exists(dirname($submodule->gitmodules_path) . '/' . $submodule->path);
      
      $submodule->is_github = strpos($submodule->url, '://github.com') !== FALSE;
      
      if($submodule->is_github){
        $submodule->author = gitmodules_get_author($submodule->url);
        $submodule->repo = gitmodules_get_repo($submodule->url);
      }
      
      $submodules[] = $submodule;
    }
  }

  return $submodules;
}

function gitmodules_get_by_name($name, $dir = '.'){
  $submodules = gitmodules_get_all($dir);

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
  if(preg_match('@://github.com/[^/]+/([^./]+)@', $submodule_url, $matches)){
    return $matches[1];
  } else {
    return FALSE;
  }
}