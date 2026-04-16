<?php

$hash = '$2y$10$lIJtcXuctaputGolGnZ.B.MUpXG5N45FvCHfLDOsDPIbo40VlxTNq';

if(password_verify("123456",$hash)){
    echo "FUNCIONA";
}else{
    echo "NO FUNCIONA";
}

?>