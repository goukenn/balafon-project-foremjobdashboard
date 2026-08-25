<?php
// @author: C.A.D. BONDJE DOUE
// @date: 20250213 11:02:06
use igk\docs\swagger\SwaggerSecurityInfo;

return [
    'title'=>'ForemJob Dashboard',
    'description'=>' ',
    'version'=>'1.2',
    'security'=>SwaggerSecurityInfo::OAUTH2_AUTH,
    'securityFlow'=>[
        'clientCredentials',
        'authorizationUrl'=>$ctrl::uri('@/api/docs/swagger.oauth'),
        'tokenUrl'=>$ctrl::uri('@/api/docs/swagger.token')
    ]
];