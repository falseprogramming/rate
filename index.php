<?php

require 'config/config.php';
require 'application/Database.php';
require 'application/Rating.php';
require 'application/Init.php';
include 'templates/header.php';
new Init();
include 'templates/footer.php';