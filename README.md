FPWHMCSBundle
==============
Allow your WHMCS users to signin and signup via symfony2

REQUIREMENTS
------------
* Symfony 2.1+
* [FP-WHMCS-Connector ](https://github.com/ifp/FP-WHMCS-Connector "FP-WHMCS-Connector")


Quick setup
-----------

Make the following alterations to have WHMCS working within your application.

**app/autoload.php**
```php
//add just after the if statement that includes composers autoloader
$loader->add('FP\\Bundle\\WHMCSBundle', __DIR__.'/../vendor/fp-whmcs-bundle/src/');
$loader->add('FP\\WHMCS', __DIR__.'/../vendor/fp-whmcs-connector/src/');
```

**app/AppKernel.php**
```php
$bundles[] = new FP\Bundle\WHMCSBundle\FPWHMCSBundle();
```

**app/config/config.yml**

```yaml
fpwhmcs:
  #please don't provide an absolute url, just the protocol and the domain name
  host:        "https://domainname" 
  username:    "api-account"
  password:    "md5-of-your-password"
```

**app/config/security.yml**

```yaml
security:
    encoders:
        FP\Bundle\WHMCSBundle\Entity\User: 
          id: fp.whmcs.encoder
    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: [ROLE_USER, ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]
    providers:
      fp.whmcs.user.provider:
        id: fp.whmcs.user.provider
    firewalls:
        dev:
            pattern:  ^/(_(profiler|wdt)|css|images|js)/
            security: false
        login:
            pattern:  ^/security$
            security: false
        secured_area:
            pattern:    ^/
            anonymous: ~
            form_login:
                check_path: /security/check
                login_path: /security
            logout:
                path:   /security/signout
                target: /

    access_control:
        - { path: ^/secured, roles: [ROLE_ADMIN, ROLE_USER] }
```

**app/config/routing.yml**

```yaml
_fp_whmcs:
  resource: "@FPWHMCSBundle/Resources/config/routing.yml"
```

## Testing ##
/secured should prompt you with a login and /signin will be your resgistration page, both should work fully providing you have the correct details in config.yml.




