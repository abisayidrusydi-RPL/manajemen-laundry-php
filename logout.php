<?php
require 'config/koneksi.php';
session_destroy();
header('Location: ' . BASE_URL);
