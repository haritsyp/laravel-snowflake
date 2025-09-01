<?php

return [
    'datacenter' => env('SNOWFLAKE_DATACENTER', 1),
    'node' => env('SNOWFLAKE_NODE', 1),
    'format' => env('SNOWFLAKE_FORMAT', 'int'),
];