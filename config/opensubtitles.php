<?php

return [
    'host' => $_ENV['OPENSUBTITLES_HOST'] ?? 'https://api.opensubtitles.com/api/v1',
    'api_key' => $_ENV['OPENSUBTITLES_API_KEY'],
    'app_name' => $_ENV['OPENSUBTITLES_APP_NAME'],
];
