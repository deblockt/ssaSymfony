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
