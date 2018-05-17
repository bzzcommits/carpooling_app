<?php require_once __SITE_PATH . '/view/_header.php'; ?>

  <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=home/signup">
    Username:
    <input type="text" name="username" />
    <br />
    Password:
    <input type="password" name="password" />
    <br />
    E-mail address:
    <input type="text" name="email" />
    <br />
    <button type="submit" name="signup">Sign up!</button>
  </form>

<?php
require_once __SITE_PATH . '/view/message.php';
require_once __SITE_PATH . '/view/_footer.php';
?>
