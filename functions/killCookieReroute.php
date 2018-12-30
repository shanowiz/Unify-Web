<?php 

if (isset($_COOKIE['activeSession'])){ 

	if (isset($_GET['id'])) {

		if ($_GET['id'] == 'manageMsg') {
			setcookie('newMessage', 'newMessage', time() - (21600 * 1), "/"); 
			header('Location:/unifyWeb/manageMsg.php');

		}else if ($_GET['id'] == 'manageUsers')  {
			setcookie('newUser', 'newUser', time() - (21600 * 1), "/"); 
			header('Location:/unifyWeb/manageUsers.php');
		}
	}

}else{
	header('Location: ../unifyWeb/login.php');
}

?>