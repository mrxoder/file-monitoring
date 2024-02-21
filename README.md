## Description
PHP script designed to help identify potential indicators of unauthorized modifications( backdoors ) within existing PHP code and files. 
While it doesn't provide absolute backdoor detection, it aims to raise red flags for further investigation.

## Usage
- Generate gpg key and add the public key to `GPGPublicKey.asc`
- Upload to php server:
    - GPGPublicKey.asc 
    - php-gpg/
    - Scanner.php 
    - scan.php
    - _scan_result/

- Open scan.php in with cron.
- Download the result at `_scan_result`, decrypt with gpg and use `local/compare.py` to compare the newest scan result with the oldest.
