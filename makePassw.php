<?php
$pass = "12345678";
echo  base64_encode(hash_hmac('md5', $pass, "7p69tiDcjRKhYJlN1Wf48"));