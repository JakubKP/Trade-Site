<?php

session_start();
session_destroy();

header("Location: /php-site/roulette/index.php");
exit;
