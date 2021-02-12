<?php
if (isset($_POST['user_button'])) {
	header('Location: select.php');
} else if (isset($_POST['admin_button'])) {
	header('Location: login_form_admin.php');
}
?>