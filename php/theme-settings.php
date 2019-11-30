<?php
require_once('inc/connect.php');
requireAuth();
$stmt = $db->prepare('SELECT id, theme, color, background, background_url, show_on_profile FROM themes WHERE source = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
if($stmt->error) {
    showError(500, 1203091, 'An error occurred while grabbing your theme settings from the database.');
}
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if($result->num_rows === 0) {
    $stmt = $db->prepare("INSERT INTO themes (source) VALUES (?)");
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    if($stmt->error) {
        showError(500, 1203090, 'An error occurred while inserting your empty theme settings into the database.');
    }
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']) {
        showJSONError(400, 1234321, 'The CSRF check failed.');
    }
    $edits = [];
    foreach($_POST as $key => &$value) {
        if(array_key_exists($key, $row) && $row[$key] !== $value) {
            switch($key) {
                case 'theme':
                    if(!in_array($value, ['0', '1', '2'])) {
                        showJSONError(400, 1338121, 'Your Theme\'s theme setting is invalid.');
                    }
                    break;
                case 'color':
                    if(!preg_match('/^[a-fA-F0-9#]+$/', $value) || strlen($value) > 7) {
                        showJSONError(400, 1338122, 'Your Theme\' color setting is invalid.');
                    }
                    break;
                case 'background':
                    if(!in_array($value, ['0', '1'])) {
                        showJSONError(400, 1338123, 'Your Theme\'s background setting is invalid.');
                    }
                    break;
                case 'show_on_profile':
                    if(!in_array($value, ['0', '1'])) {
                        showJSONError(400, 1338125, 'Your Theme\'s show on profile setting is invalid.');
                    }
            }
            $edits[] = $key . ' = "' . $db->real_escape_string($value) . '"';
        }
    }
    if(count($edits) > 0) {
        $stmt = $db->prepare('UPDATE themes SET ' . implode(', ', $edits) . (!isset($_POST['color']) ? ', color = NULL' : '') . ' WHERE source = ?');
        $stmt->bind_param('i', $_SESSION['id']);
        $stmt->execute();
        if($stmt->error) {
            showJSONError(500, 3928989, 'There was an error while saving your theme settings.');
        }
    }
} else {
    $title = 'Theme Settings';
    require_once('inc/header.php');
    initUser($_SESSION['username']);
    ?><div class="main-column messages">
        <div class="post-list-outline">
            <h2 class="label">Theme Settings</h2>
            <form class="setting-form" action="/settings/themes" method="post">
                <input type="hidden" name="token" value="<?=$_SESSION['token']?>">
                <ul class="settings-list">
                    <li class="theme-settings">
                        <p class="settings-label">Which mode do you prefer using?</p>
                        <label>
                        <input type="radio" id="themetype_0" name="theme" value="0" <?php if($row['theme'] == 0) {echo 'checked';} ?> />
                        Light
                        </label>
                        <label>
                        <input type="radio" id="themetype_1" name="theme" value="1" <?php if($row['theme'] == 1) {echo 'checked';} ?> />
                        Dark
                        </label>
                        <label>
                        <input type="radio" id="themetype_2" name="theme" value="2" <?php if($row['theme'] == 2) {echo 'checked';} ?> />
                        Darker
                        </label>
                    </li>
                    <li>
                        <p class="settings-label">Set your custom theme color.</p>
                        <div class="select-content">
                            <div class="select-button">
                                <input type="color" name="color" <?=(empty($row['color']) ? 'value="#000000"' : 'value="'.$row['color']).'"'?> style="height: 24px;margin-right: 5px;vertical-align: middle;">
                                <input type="button" value="reset to default" onclick="$('input[type=\'color\']').remove();">
                            </div>
                        </div>
                    </li>
                    <li class="theme-settings">
                        <p class="settings-label">Choose the background for your theme.</p>
                        <label>
                        <input type="radio" id="background_1" name="background" value="0" <?php if($row['background'] === 0) {echo 'checked';} ?> />
                        Tiled
                        </label>
                        <label>
                        <input type="radio" id="background_2" name="background" value="1" <?php if($row['background'] === 1) {echo 'checked';} ?> />
                        Striped
                        </label>
                        <label>
                        <!-- <input type="radio" id="background_3" name="background" value="1" <?php if($row['background'] === 2) {echo 'checked';} ?> />
                        Custom
                        </label>
                        <label class="file-button-container">
                        <span class="input-label">Custom background image <span>An image with a 128x128 size is recommended. Also note that you must have "Custom" checked on the background settings for the image to show.</span></span>
                        <input type="file" class="file-button" name="background_url" accept="image/*">
                        </label> -->
                        <label>
                    </li>
                    <li>
                        <p class="settings-label">Do you want your theme to show when other people visit your profile?</p>
                        <div class="select-content">
                            <div class="select-button">
                                <select name="show_on_profile">
                                    <option value="0"<?=$row['show_on_profile'] === 0 ? ' selected' : ''?>>Don't show</option>
                                    <option value="1"<?=$row['show_on_profile'] === 1 ? ' selected' : ''?>>Do show</option>
                                </select>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="form-buttons">
                    <input type="submit" class="black-button apply-button" value="Save Settings">
                </div>
            </form>
        </div>
    </div><?php
    require_once('inc/footer.php');
}
?>