<?php

if (isset($_COOKIE['newUser'])) {
	echo "works";
}else {
	echo "dont work";
}

echo  bin2hex(mcrypt_create_iv(11, MCRYPT_DEV_URANDOM));

//php if (isset($_COOKIE['newMessage'])) {setcookie('newMessage','', time() - (315360000 * 1), "/");}

?>
