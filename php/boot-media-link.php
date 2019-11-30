<?php
require_once('inc/connect.php');

if(!isset($_GET['token'])) {
    exit("Please specify the login key.");
}

//This will get the data from Boot_Media's api to check if the user exists or not.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, BOOT_MEDIA_LINK.'api/users/'.$_GET['token'].'/info.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$data = json_decode($result, true);

if($data["success"] == 0) {
    exit('A Boot_Media account associated with this token couldn\'t be found.');
}

//This will get Boot_Media account token from users.
$stmt = $db->prepare("SELECT bm_session FROM users WHERE bm_session = ?");
if(!$stmt) {
    $error = 'There was an error while preparing to check if your account exists.';
    goto showForm;
}
$stmt->bind_param('s', $_GET['token']);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows !== 0) {
    $stmt = $db->prepare('SELECT id, avatar, has_mh, level FROM users WHERE bm_session = ? ORDER BY id DESC LIMIT 1');
    if(!$stmt) {
        $error = 'There was an error while preparing to fetch your account from the database.';
        goto showForm;
    }
    $stmt->bind_param('s', $_GET['token']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array();

    $_SESSION['id'] = $row['id'];
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['avatar'] = $row['avatar'];
    $_SESSION['has_mh'] = $row['has_mh'];
    $_SESSION['level'] = $row['level'];
    $token = bin2hex(openssl_random_pseudo_bytes(16));
    $stmt = $db->prepare('INSERT INTO tokens (source, value) VALUES (?, ?)');
    $stmt->bind_param('is', $row['id'], $token);
    $stmt->execute();
    if($stmt->error) {
        $error = 'There was an error while inserting your login token into the database.';
        goto showForm;
    }
    setcookie('mwauth', $token, time() + 2592000, '/');

    http_response_code(302);
    if(!empty($_GET['callback']) && substr($_GET['callback'], 0, 1) === '/') {
        header('Location: ' . $_GET['callback']);
    } else {
        header('Location: /');
    }
    exit();
}

showForm:
$title = 'Account Link';
require_once('inc/header.php');
?><div class="post-list-outline no-content center">
    <form>
    <br>
    <img src="/assets/img/menu-logo.png"><br><br>
    <p>Your Boot_Media account isn't linked to any Miiverse World accounts. Would you like to link it to an already existing account, or create a new one?</p><br><br>
    <a class="black-button" href="/login/existing/<?php echo $_GET['token']; ?>">Login with existing account.</a><br><br>
    <a class="black-button" href="/signup/<?php echo $_GET['token']; ?>">Create a Miiverse World account.</a><br><br>
    </form>
</div><?php
require_once('inc/footer.php');