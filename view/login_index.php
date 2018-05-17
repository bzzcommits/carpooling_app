<?php require_once __SITE_PATH . '/view/_header.php'; ?>

  <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=home/login">
    Username:
    <input type="text" name="username" />
    <br />
    Password:
    <input type="password" name="password" />
    <br />
    <button type="submit" name="login">Log in!</button>
  </form>

<?php
require_once __SITE_PATH . '/view/message.php';
require_once __SITE_PATH . '/view/_footer.php';
?>
