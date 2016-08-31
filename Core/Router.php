<?php
 
namespace Core;


class Router {
	
	
	protected $routes = array();
	
	
	protected $params = array();
	
	
	protected $language;
	
	
	
	public function getRoutes()
	{
		return $this->routes;
	}
	
	
	
	   public function getParams()
    {
        return $this->params;
    }
	
	
	
	public function getLanguage()
	{
	return $this->language;
	}
	
	
	public function __construct(){
		
		$this->language = Config::get('DEFAULT_LANGUAGE');
	}
	
	
	
	//tablica ruttingu dodaje, m in dzieli na controlls i actions i zwraca dane - TU URL NIE JEST SPRAWDZANY A JEDYNIE DANE ZE SZTYWNIE ZDEFINIOWANYCH
	public function add($route,$params=[]){
		echo $route."<--to add() function<br>";
		        // Convert the route to a regular expression: escape forward slashes
		        //Konwertuje œcie¿kê do regularnego tekstu(bez \ - escape forward slashes, by uciec od ukoœników /) w przypadku gdy wpadnie z ukoœnikami
		        $route = preg_replace('/\//', '\\/', $route);
			echo $route."<--to add() function<br>";	
		        // Convert variables e.g. {controller}
		        //W przypadku gdy wpadnie {controller},{action} Konwertuje ustawia zmienne na array i dalej do wzpru
		        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
				echo $route."<--to add() function<br>";
		        // Convert variables with custom regular expressions e.g. {id:\d+}
		        //Konwertuje zmienne W przypadku gdy wpadnie {id:\d+}
		        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
				echo $route."<--to add() function<br>";
		        // Add start and end delimiters, and case insensitive flag
		        $route = '/^' . $route . '$/i';
	
				//wpisywanie do tablicy
		        $this->routes[$route] = $params;
		
				echo "<br><br>Tablica zdefiniowa na sztywno wychodzi z preg_replace:<br><pre>";
				var_dump($this->routes[$route]);
				echo "</pre>";
	}


// TU PRZYGOTOWANE DANE Z FUNKCJI WYZEJ S¥ POWOWNYWANE Z PRZESLANYM URL-EM
	public function match($url){
        foreach ($this->routes as $route => $params) {
					echo "<pre>URL Wpisane dane url ";
		        	var_dump($url);
					echo "</pre>";
					echo "<pre>pattern/wzor ";
		        	var_dump($route);
					echo "</pre>";
            if (preg_match($route, $url, $matches)) {
                // Get named capture group values
            echo "<pre>MAtches ";
        	var_dump($url);
			echo "</pre>";
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;
                return true;
		}
	}
        return false;
    }	
	
    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
        	
        	if(isset($this->params['language'])){
				$lang = $this->params['language'];
        	}else{
 				$lang = $this->language;       		
        	}
			Lang::load($lang);
            
            $controller = $this->params['controller'];
			
            $controller = $this->convertToStudlyCaps($controller);
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
            	var_dump($this->params);
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();

                } else {
                    throw new \Exception("Method $action (in controller $controller) not found");
                }
            } else {
                throw new \Exception("Controller class $controller not found");
            }
        } else {
            throw new \Exception('No route matched.', 404);
        }
    }



/**
 * 
 * converting
 */


    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }
	
	    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }
	
	
	    protected function removeQueryStringVariables($url)
	    {
	        if ($url != '') {
	            $parts = explode('&', $url, 2);
	
	            if (strpos($parts[0], '=') === false) {
	                $url = $parts[0];
	            } else {
	                $url = '';
	            }
	        }
	
	        return $url;
	    }
	
/**
 * 
 * Get Namespace
 * 
 */	
	
	    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }	
	
}


