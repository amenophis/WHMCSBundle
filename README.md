FP-WHMCSBundle
==============

Example configs
---------------

app/config/config.yml
---------------------
```yaml
fpwhmcs:
  host:        "https://domainname" #don't provide an absolute url, just the protocol and the domain name please
  username:    "api-account"
  password:    "md5-of-your-password"
```

app/config/security.yml
-----------------------
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
```