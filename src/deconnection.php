<?php
session_start(); // INITIALISE LA SESSION
session_unset(); // DESCTIVER LA SESSION
session_destroy(); // DETRUIRE LA SESSION
header('location: ../');
exit();
