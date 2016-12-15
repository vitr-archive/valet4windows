start /b php-cgi -b 127.0.0.1:9000
start /b bin/caddy --conf="%HOMEDRIVE%%HOMEPATH%\.valet\Caddyfile"
