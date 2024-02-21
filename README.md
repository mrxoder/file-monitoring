- Generate gpg key and add the public key to `GPGPublicKey.asc`
- Upload to php server:
`
    -GPGPublicKey.asc 
    -php-gpg
    -README.md
    -Scanner.php 
    -scan.php
    -_scan_result
`
- Open scan.php in Browser or with cron
- Download the result at '_scan_result', decrypt with gpg and use 'local/compare.py' to compare the newest scan result with the oldest.
