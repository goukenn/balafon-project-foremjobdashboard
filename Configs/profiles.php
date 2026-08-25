<?php
// @author: C.A.D. BONDJE DOUE
// @desc: profiles definition
// @date: 20250210 15:58:30
use com\igkdev\projects\ForemJobDashboard\EnumAuthorizations;

return [
    "admin"=>[
        "read",
        "write",
        "update",
        "patch",
        "create",
        "read",
        "search",
        "document_management"
    ],
    "provider"=>[
        "create",
        'write',
        "read",
        "search",
        EnumAuthorizations::document_management
    ],
    'consultant'=>[
        'read',
        'search',
        EnumAuthorizations::document_management
    ]
];