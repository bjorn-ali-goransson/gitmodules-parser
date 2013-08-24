PHP .gitmodules updater
============================

API for updating github submodules to latest version of chosen branch.

Submodule object
----------------------------

The API returns instances of [stdClass](http://lmgtfy.com/?q=stdClass) with the following properties:

* ```$submodule->name``` is the name of the submodule. Not really used for anything.
* ```$submodule->path``` is the local, relative path of the folder that has the submodule contents
* ```$submodule->url``` is the URL to the repo.
* ```$submodule->author``` is the GitHub username who owns the repo.
* ```$submodule->repo``` is the GitHub repo name.
* ```$submodule->is_github``` is true if the submodule points to a GitHub repo.

Functions
----------------------------

### gitmodules_get_all($dir = '.')

Returns an array of all Submodule objects referenced in the ```.gitmodules``` file located in the directory ```$dir```. No trailing slash is necessary.

### gitmodules_get_all($name, $dir = '.')

Returns the Submodule objects named $name referenced in the ```.gitmodules``` file located in the directory ```$dir```. No trailing slash is necessary.