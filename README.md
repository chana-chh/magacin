# MAGACIN

- url_for() - returns the URL for a given route. e.g.: /hello/world
- full_url_for() - returns the URL for a given route. e.g.: https://www.example.com/hello/world
- is_current_url() - returns true is the provided route name and parameters are valid for the current path.
- current_url() - returns the current path, with or without the query string.
- get_uri() - returns the UriInterface object from the incoming ServerRequestInterface object
- base_path() - returns the base path.

Interno prebacivanje (nalozi), pretvaranje sirovina->kljuk->meka->ljuta->gotova->flasirana ???

Za svaku izmenu dodati ```$data['updated_at'] = date('Y-m-d H:i:s');```