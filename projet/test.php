<?php

if (extension_loaded('sqlsrv')) {
    echo "SQLSRV extension is enabled.\n";
} else {
    echo "SQLSRV extension is NOT enabled.\n";
}


if (extension_loaded('pdo_sqlsrv')) {
    echo "PDO_SQLSRV extension is enabled.\n";
} else {
    echo "PDO_SQLSRV extension is NOT enabled.\n";
}
?>