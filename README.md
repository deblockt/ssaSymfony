SSA Symfony bundle
==========

Ssa is a framework for access to your php service in your javascript code. This project is the ssa integration on symfony 2.
[Ssa project](https://github.com/deblockt/ssa)

### Installation

Ssa bundle installation is very simple, you need just to add composer dependency.

*composer.json*
```json
"require": {
  "ssa/core" : "dev-master",
  "ssa/ssa-bundle" : "dev-master",
}
```

Add the ssa routing in your routing.yml

*routing.yml*
```yml
_ssa:
    resource: "@SsaBundle/Resources/config/routing.yml"
```

After you can register your services into config.yml

*config.yml*
```yml
ssa :
    services :
        # serviceName is the ssa service name
        # service : is the symfony serivce
        serviceName : {service : 'ssa.test.service'}
        # or you can just export any methods of this service
        serviceName2 : {service : 'ssa.test.service', methods : ['methodToImport']}
        # if your service is not a symfony service you can use the class attribute
        serviceName3 : {class : '\Path\To\Your\Class', methods : ['methodToImport']}      
```

And you can Simply import the javascript service with assetic, like this :

*file.html.twig*
```html
{% javascripts 
    'ssa:serviceName'
    'ssa:serviceName1'
    'ssa:serviceName2'
%}
<script type="text/javascript" src="{{asset_url }}"></script>
{% endjavascripts  %}
    
```

you can now simply call your php service into your javascript file : 
```javascript
serviceName1
    .methodToImport('param1', {objectProp : 'ObjectValue', objectProp2 : 'ObjectValue2'})
    .done(function(data){
        console.log(data);
    });
```

### customization

You can customize the framework with you own classes or change parameters.

#### Parameters

You can change any parameters on config.yml

*config.yml*
```yml
ssa :
    configuration :
        # the debug configuration, default is the symfony configuration
        debug : true | false
        # the cache configuration, by default there are no cache, the cachemode is not mandatory with symfony
        cacheMode : file | apc | memcache
        # the cache directory if cacheMode is file. default it's the kernel.cache_dir
        cacheDirectory : 
        # the host for memcache cacheMode
        memcacheHost :
        # the port for memcache cacheMode
        memcachePort :
        # path to ssa js file, if you have your own ssa js implementation. Path begin in web directory
        ssaJsFile :

```

#### Implementation

You can change ssa implementation, add ssa parameters resolver, change route generator.

##### Route manager

Routes are use for generate url to call php services, by default the ssa_run_service route is used. 
You have two way for change route generation. 
The first is to change the route name used :

*service.yml*
```yml
parameters :
    ssa.runner.route : 'your_own_ssa_route_name'
```

Or you can completly change the class use for generate route, your class must implements ssa\converter\UrlFactory interface, your constructor must have two parameters  Symfony\Component\Routing\RouterInterface $router and  $routeName. For change the class used you must change the ssa.urlFactory.class parameter :

*service.yml*
```yml
parameters :
    ssa.runner.route : Your\Own\UrlFactory
```


