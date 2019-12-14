<?php
require_once('connect.php');

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?=isset($title) ? htmlspecialchars($title) . ' - ' : ''?>Project ULTIMA</title>
        <meta http-equiv="content-style-type" content="text/css">
        <meta http-equiv="content-script-type" content="text/javascript">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-title" content="Project ULTIMA">
        <meta name="description" content="Project ULTIMA is a service that lets you communicate with other users from around the world.">
        <meta name="keywords" content="Miiverse,clone,Indigo,Closedverse,Cedar,Ciiverse,PF2M,Nintendo,Hatena,Ultima">
        <meta property="og:locale" content="en_US">
        <!--<meta property="og:locale:alternate" content="ja_JP">
        <meta property="og:locale:alternate" content="es_LA">
        <meta property="og:locale:alternate" content="fr_CA">
        <meta property="og:locale:alternate" content="pt_BR">
        <meta property="og:locale:alternate" content="en_GB">
        <meta property="og:locale:alternate" content="fr_FR">
        <meta property="og:locale:alternate" content="es_ES">
        <meta property="og:locale:alternate" content="de_DE">
        <meta property="og:locale:alternate" content="it_IT">
        <meta property="og:locale:alternate" content="nl_NL">
        <meta property="og:locale:alternate" content="pt_PT">
        <meta property="og:locale:alternate" content="ru_RU">-->
        <meta property="og:title" content="<?=isset($title) ? htmlspecialchars($title) . ' - ' : ''?>Project ULTIMA">
        <meta property="og:type" content="article">
        <meta property="og:url" content="http<?=($_SERVER['HTTPS'] || HTTPS_PROXY) ? 's' : ''?>://<?=$_SERVER['SERVER_NAME']?>">
        <meta property="og:description" content="Project ULTIMA is a service that lets you communicate with other users from around the world.">
        <meta property="og:site_name" content="Project ULTIMA">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:domain" content="<?=$_SERVER['SERVER_NAME']?>">
        <!--<link rel="alternate" hreflang="x-default" href="https://miiverse.nintendo.net/">
        <link rel="alternate" hreflang="ja-JP" href="https://miiverse.nintendo.net/?locale.lang=ja-JP">
        <link rel="alternate" hreflang="en-US" href="https://miiverse.nintendo.net/?locale.lang=en-US">
        <link rel="alternate" hreflang="es-MX" href="https://miiverse.nintendo.net/?locale.lang=es-MX">
        <link rel="alternate" hreflang="fr-CA" href="https://miiverse.nintendo.net/?locale.lang=fr-CA">
        <link rel="alternate" hreflang="pt-BR" href="https://miiverse.nintendo.net/?locale.lang=pt-BR">
        <link rel="alternate" hreflang="en-GB" href="https://miiverse.nintendo.net/?locale.lang=en-GB">
        <link rel="alternate" hreflang="fr-FR" href="https://miiverse.nintendo.net/?locale.lang=fr-FR">
        <link rel="alternate" hreflang="es-ES" href="https://miiverse.nintendo.net/?locale.lang=es-ES">
        <link rel="alternate" hreflang="de-DE" href="https://miiverse.nintendo.net/?locale.lang=de-DE">
        <link rel="alternate" hreflang="it-IT" href="https://miiverse.nintendo.net/?locale.lang=it-IT">
        <link rel="alternate" hreflang="nl-NL" href="https://miiverse.nintendo.net/?locale.lang=nl-NL">
        <link rel="alternate" hreflang="pt-PT" href="https://miiverse.nintendo.net/?locale.lang=pt-PT">
        <link rel="alternate" hreflang="ru-RU" href="https://miiverse.nintendo.net/?locale.lang=ru-RU">-->
        <link rel="shortcut icon" href="/assets/img/favicon.ico">
        <link rel="apple-touch-icon" sizes="57x57" href="/assets/img/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/assets/img/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/assets/img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/assets/img/apple-touch-icon-144x144.png">
        <link rel="stylesheet" type="text/css" href="/assets/css/Ultima.css">
        <?php 
        if(!empty($_SESSION['username']) || isset($rowtu)) {
            $stmt = $db->prepare('SELECT id, theme, color, background, background_url, show_on_profile FROM themes WHERE source = ?');
            $stmt->bind_param('i', $_SESSION['id']);
            $stmt->execute();
            if($stmt->error) {
                showError(500, 1203091, 'An error occurred while grabbing your theme settings from the database.');
            }
            $resultt = $stmt->get_result();
            $rowt = $resultt->fetch_assoc();
            if(!isset($rowtu)) {
                $background = $rowt['background'];
                $color = $rowt['color'];
            } else {
                $background = $rowtu['background'];
                if(empty($rowtu['color']) || $rowtu['color'] === '#000000') {
                    $color = $rowt['color'];
                } else {
                    $color = $rowtu['color'];
                }
            }
            if(!empty($color) & $color !== '#000000') {
                $colori = mb_substr($color,1,7);
                ?>
                <script>
                    var mainColor = "<?=$colori?>"
                    var mainColorR = 0
                    var mainColorG = 0
                    var maincolorB = 0
                    var darkColor
                    var slightlyDarkColor
                    var darkerColor
                    var lightColor
                    var lightColorR
                    var lightColorG
                    var lightColorB
       
 
                    function changeThemeColor() {
           
                    /* Change hex to RGB for maths (sets 3 variables) */
                    hexToRgb(mainColor);  
           
           
                    /* Function does not output anything if value is 0, so this has to be done*/
                    if (!(mainColorR)) {mainColorR = 0;}
                    if (!(mainColorG)) {mainColorG = 0;}
                    if (!(mainColorB)) {mainColorB = 0;}

                    /* Get stuff for light color */
                    if(mainColorR > 85) {lightColorR = mainColorR * 2} else {lightColorR = mainColorR + 175;}
                    if(lightColorR > 255) {lightColorR = 255;}
                    if(mainColorG > 85) {lightColorG = mainColorG * 2} else {lightColorG = mainColorG + 175;}
                    if(lightColorG > 255) {lightColorG = 255;}
                    if(mainColorB > 85) {lightColorB = mainColorB * 2} else {lightColorB = mainColorB + 175;}
                    if(lightColorB > 255) {lightColorB = 255;}
           
                    /* Calculate darkColor & darkerColor */
                    darkColor = rgb2hex(mainColorR / 4, mainColorG / 4, mainColorB / 4);
                    lightColor = rgb2hex(lightColorR, lightColorG, lightColorB);
                    slightlyDarkColor = rgb2hex(mainColorR / 1.2, mainColorG / 1.2, mainColorB / 1.2);
                    darkerColor = rgb2hex(mainColorR / 8, mainColorG / 8, mainColorB / 8);
           
                    /* Set CSS variables */
                    document.documentElement.style.setProperty("--theme", `rgb(${mainColorR}, ${mainColorG}, ${mainColorB})`);
                    document.documentElement.style.setProperty("--theme-dark", darkColor);
                    document.documentElement.style.setProperty("--theme-slightly-dark", slightlyDarkColor);
                    document.documentElement.style.setProperty("--theme-darker", darkerColor);
                    document.documentElement.style.setProperty("--theme-light", lightColor);
           
                    /* so stuff doesnt complain bc theres no return statement */
                    return 0;
                    }
           
                    /* hex -> rgb */
                     function hexToRgb(hex) {
                          var bigint = parseInt(hex, 16);
                          mainColorR = (bigint >> 16) & 255;
                          mainColorG = (bigint >> 8) & 255;
                          mainColorB = bigint & 255;
                     
                          return mainColorR + "," + mainColorG + "," + mainColorB;
                      }
                     
                    /* rgb -> hex */
                    function rgb2hex(red, green, blue) {
                            var rgb = blue | (green << 8) | (red << 16);
                            return "#" + (0x1000000 + rgb).toString(16).slice(1)
                    }
 
                    function toDefault() {
                    document.documentElement.style.setProperty("--theme", "initial");
                    document.documentElement.style.setProperty("--theme-dark", "initial");
                    document.documentElement.style.setProperty("--theme-slightly-dark", "initial");
                    document.documentElement.style.setProperty("--theme-darker", "initial");
                    document.documentElement.style.setProperty("--theme-light", "initial");
                    }
                    changeThemeColor();

                    /*
                    Meltstrap - The person who originally made this code.
                    Chance - Modified it a bit by adding theme-slightly-dark and theme-light.
                    */
                </script>
            <?php
            }
            if($rowt['theme'] === 1) { ?> 
                <link rel="stylesheet" type="text/css" href="/assets/css/darkness.css">
            <?php 
            } elseif($rowt['theme'] === 2) { ?>
                <link rel="stylesheet" type="text/css" href="/assets/css/darker.css">
            <?php }
            if($background === 1 & $rowt['theme'] === 1) { ?>
                <style>
                    #wrapper, #image-header-content {
                    background: var(--theme, #ff37e5) url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAEpElEQVR4nO2dW3LiQBAEE8kmOPae2w7j/ZjFa0CAHi1N16jqABMZlf2pKB1Op9MfgnI8Hun7Puq5q5zPZz4+Pvj+/g55z6yFs4t6zIWWqLBeOEMOwIWWqLD+5lx8AC60RIX1lnPRAbjQEhXWIc7ZB+BCS1RYH3HOOgAXWqLC+oxz8gG40BIV1leckw7AhZaosI7hHH0ALrREhXUs56gDcKElKqxTOF8egAstUWGdyvn0AFxoiQrrHM6HB+BCS1RY53IOHoALLVFhXcJ5dwAutESFdSnn1QG40BIV1gjOnwNwoSUqrFGcHbjQS1RYIzk7F1qiwhrN2e29UNBhXYPzLeSlm3x9ffH5+Zm+UNi3/L7v4z4KvcTydeTDwk/CbmP5WvIh8AAsX08+BB2A5WvKh4ADOJ/Plh+cLTkXHYBKoaDDujXn7ANQKRR0WGtwzjoAlUJBh7UW5+QDUCkUdFhrck46AJVCQYe1NufoA6gNOiUqrBk4Rx1ABtCxUWHNwvnyALKAjokKaybOpweQCfRVVFizcT48gGygz6LCmpFz8AAygj6KCmtWzrsDyAo6FBXWzJxXB5AZ9DYqrNk5fw4gO+jvqLAqcHagAXqJCqsKZ6cCCjqlqnACdCqgKqWqcEL5kqtTAFUpVYUTinxPxQZGhRP+y4eAbwItX4cTruWDp2IXR4UT7uWDp2IXRYUThuWDp2JnR4UTHssHT8XOigonPJcPnoqdHBVOeC0fPBU7KSqcME4+eCp2dFQ4Ybx88FTsqKhwwjT54KnYl1HhhOnywVOxT6PCCfPkg6diH0aFE+bLB0/FDkaFE5bJB0/F3kWFE5bLB0/FXkWFE2Lkg6dif6LCCXHywVOxgA4nxMo/HA6eilXhhHj5x+MxfikUdEpV4YSV5Hdd/AGolKrCCevJh+CpWJVSVThhXfkQeAAqpapwwvryIegAVEpV4YRt5EPQVKxCqSqcsJ182MlUrAonbCsfdjAVq8IJ28uHxqdiVTihjnxoeCpWhRPqyYdGp2JVOKGufGhwKlaFE+rLh8amYlU4IYd8aGgqVoUT8siHRqZiVTghl3xoYCpWhRPyyQfxqVgVTsgpH4SnYlU4Ia98EJ2KVeGE3PJBcCpWhRPyywexqVgVTtCQD/Cm8t9fy1/l+106y4+NknyJqVjLX09++qlYy19XPiSeirX89eVD0qlYy99GPiScirX87eRDsqlYy99WPiSairX87eVDkqlYy68jHxJMxVp+PflQeSrW8uvKh4pTsZZfXz5Umoq1/BzyocJUrOXnkQ8bT8Vafi75sOFUrOXnkw8bTcVafk75sMFUrOXnlQ8rT8Vafm75sOJUrOXnl7/aVKzla8h/f3/f71IoWH7f97yFvPgvlq8hf5WpWMvXkw87WwoFyw+firV8Xfmwk6VQsPzwqVjL15cPjS+FguWHT8VafjvyodGlULD88KlYy29PPjS2FAr1C52SDKzNLIVCjkLHJgtrE0uhkKfQMcnEKr8UCrkKfZVsrNJLoZCv0GfJyCq7FAo5C32UrKySS6GQt9ChZGaVWwqF3IXeJjur1FIo5C/0dxRYO8vfr3yAv3rECG2I4F0DAAAAAElFTkSuQmCC') !important;
                        }
                </style>
            <?php } elseif($background === 1 & $rowt['theme'] === 0) { ?>
                <style>
                    #wrapper, #image-header-content {
                    background: var(--theme, #ff37e5) url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo4RjUzOTU4RTEwRjlFOTExODczREM0RUMwQTg1RDgxOSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpBMUU1RjI2Q0Y5MTAxMUU5QkE3NEQ4QjZFRUJGOUI5MyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpBMUU1RjI2QkY5MTAxMUU5QkE3NEQ4QjZFRUJGOUI5MyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjkwNTM5NThFMTBGOUU5MTE4NzNEQzRFQzBBODVEODE5IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjhGNTM5NThFMTBGOUU5MTE4NzNEQzRFQzBBODVEODE5Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+WiiiYgAAA61JREFUeNrs3Mtq6zAURmHFaUshtMM8bx8yT1EIKSH0ktL6IA8MwXYiW9Kh+99Lk8yEom/lgjBanU6nl1BgbDabUHO8vb2Fw+EQttttkfl+fn7C8/NzlbUej8ew3++LrfXh4SHc399XWWtjBf/x8bEo/mq1qoYfsUri11jr9/d3aNs2P4D/hR/RSuI/PT1Vw//9/S2Kf3d3Vxw/zvn+/p4XAPi28bN+AsC3j784APA18BcFAL4O/uwAwNfCnxUA+Hr4yQGAr4mfFAD4uvg3AwBfG/9qAODr408GAL4P/NEAwPeDPwgAfF/4FwGA7w+/DwB8n/hdAOD7xU86CAJfF79qAOD/ffzdbhdWbdu+gO/wk980Yb1el/8GAN8OflxvA75f/KL/AcC3h18sAPBt4hcJAHy7+NkBgG8bPysA8O3jLw4AfA38RQGAr4M/OwDwtfBnBQC+Hn5yAOBr4icFAL4u/s0AwNfGvxoA+Pr4kwGA7wN/NADw/eAPAgDfF/5FAOD7w+8DAN8nfjcv+H7xu7nj9avg+8M/n8/h4+MjNKWvXwXfBn70ivvZgO8Xf/IgCHwf+NkBgG8bPysA8O3jLw4AfA38RQGAr4M/OwDwtfBnBQC+Hn5yAOBr4icFAL4u/s0AwNfGvxoA+Pr4kwGA7wN/NADw/eAPAgDfF/5FAOD7w+8DAN8nfrdO8P3iv76+1rkpFPy/jx8fBI7vvQHfL358bcD3iz95EAS+D/yiAYBvD79YAODbxC8SAPh28bMDAN82flYA4NvHXxwA+Br4iwIAXwd/dgDga+HPCgB8PfzkAMDXxE8KAHxd/JsBgK+NfzUA8PXxJwMA3wf+aADg+8EfBAC+L/yLAMD3h98HAL5P/G4PwPeL3+3Dfr8H3yH+19dX+Pz8LHdVLPi28Nu27dbbgO8Xf/IgCHwf+NkBgG8bPysA8O3jLw4AfA38RQGAr4M/OwDwtfBnBQC+Hn5yAOBr4icFAL4u/s0AwNfGvxoA+Pr4kwGA7wN/NADw/eAPAgDfF/5FAOD7w+8DAN8nfren4PvFr3ZVLPh/Hz/uZ5WrYsG3gx8vCG/A94s/eRAEvg/8YgGAbxO/SADg28XPDgB82/hZAYBvH39xAOBr4C8KAHwd/NkBgK+FPysA8PXwkwMAXxM/KQDwdfFvBgC+Nv7VAMDXx58MAHwf+KMBgO8HfxAA+L7wLwIA3x9+HwD4PvH7AEri73a7KvhxlMSPT8TWvIGz9NO7NfDj+CfAAF03T3HxH15NAAAAAElFTkSuQmCC') !important;
                        }
                </style>
            <?php } elseif($background === 1 & $rowt['theme'] === 2) { ?>
                <style>
                    #wrapper, #image-header-content {
                    background: #1c1c1c url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAAJcEhZcwAAEnQAABJ0Ad5mH3gAAAPcSURBVHhe7dxNTvNaEAZhJxLsgP0vkB3AIN+tXJSjKE7in3bi7lMlIQQD1PLzTsLAh2EYTv99hfT19TV8fn7+/RTb6XQafn9/h+/v77/frGvLW+nn5yfFrce/76sTv5UFnztDBiB+KxM+d64egPitbPi0agDitzLi0+IBiN/Kik+LBiB+KzM+zR6A+K3s+DRrAOK3KuDT5AGI36qCT5MGIH6rEj49HYD4rWr49HAA4rcq4tPdAYjfqopPowMQv1UZn24GIH6rOj5dDUD8Vg/4dBmA+K1e8Ok8APFbPeHTUfxWb/h0FP//esTnztGPgWsTP/5WnukWd4YPQPxt8Ld6pqEDED8XPoUNQPx8+BQyAPFz4tPqAYifF59WDUD83Pi0eADi58enRQMQvwY+zR6A+HXwadYAxK+FT5MHIH49fJo0APFr4tPTAYhfF58eDkD82vh0dwDi18en0QGI3wc+3QxA/H7w6WoA4veFT5cBiN8fPp0HIH6f+HQUv198OoofWyZ8nmfYu4LFz4fPnaP/B5ib+DnxafUAxM+LT6sGIH5ufFo8APHz49OiAYhfA59mD0D8Ovg0awDi18KnyQMQvx4+TRqA+DXx6ekAxK+LTw8HIH5tfLo7APHr49PoAMTvA59uBiB+P/h0NQDx+8KnywDE7w+fzgMQv0982vRVsSR+bNHPc7NXxZL4sUU/z4+Pj/GPgRGJH9sW+IfDYZsBiB/bVvgUPgDxY9sSn0IHIH5sW+NT2ADEj+0V+BQyAPFjexU+rR6A+LG9Ep9WDUD82F6NT4sHIH5s78CnRQMQP7Z34dPsAYgf2zvxadYAxI/t3fg0eQDix7YHfJo0APFj2ws+PR2A+LHtCZ8eDkD82PaGT3cHIH5se8Sn0QGIH9te8elmAOLHtmd8uhqA+LHtHZ8uAxA/tgz4dB6A+LFlwaej+LFlwudW/vKuXxUr/nb43Dr6MXBu4ufEp9UDED8vPq0agPi58WnxAMTPj0+LBiB+DXyaPQDx6+DTrAGIXwufJg9A/Hr4NGkA4tfEp6cDEL8uPj0cgPi18enuAMSvj0+jAxC/D3y6GYD4/eDT1QDE7wufLgMQvz98Og9A/D7xabNXxYq/f3xu3eRVseLnwOfW0Y+BaxI/Dz63hg5A/Fz4FDYA8fPhU8gAxM+JT6sHIH5efFo1APFz49PiAYifH58WDUD8Gvg0ewDi18GnWQMQvxY+TR6A+PXwadIAxK+JT08HIH5dfHo4APFr49PdAYhfH59GByB+H/h0MwDx+8GnqwGI3xc+XQYgfn/4dB6A+H3i01H8fvGHYRj+AZQIxJk2ZEbRAAAAAElFTkSuQmCC') !important;
                        }
                </style>
            <?php } 
        } ?>
        <script src="/assets/js/complete-en.js"></script>
        <!--<script type="application/json" class="js-ad-slot-spec" data-spec='{"laptop_size":[300,250],"tablet_size":[468,60],"smartphone_size":[320,100],"ad_key":"div-gpt-ad-1438756213573-1","ad_unit_path":"/94393651/miiverse-communities-top"}'></script>
        <script type="application/json" class="js-ad-slot-spec" data-spec='{"laptop_size":[300,250],"tablet_size":[468,60],"smartphone_size":[320,100],"ad_key":"div-gpt-ad-1438756213573-0","ad_unit_path":"/94393651/miiverse-communities-bottom"}'></script>-->
    </head>
    <body class="<?php if(empty($_SESSION['username'])) echo 'guest '; if(!empty($class)) echo $class; if(isset($reborn)) echo '" id="miiverse-will-reborn'; echo '" data-token="' . $_SESSION['token']; ?>">
        <div id="wrapper">
            <div id="sub-body">
                <menu id="global-menu">
                    <li id="global-menu-logo">
                        <h1><a href="/"><img src="/assets/img/Ultima.png" alt="Project ULTIMA" width="165" height="30"></a></h1>
                    </li>
                    <?php if(empty($_SESSION['username'])) { ?><li id="global-menu-login">
                            <form id="login_form" action="/login" method="post">
                                <input type="image" alt="Sign in" src="/assets/img/en/signin_base.png">
                            </form>
                        </li>
                    <?php } else { ?><li id="global-menu-list">
                        <ul>
                            <li id="global-menu-mymenu"<?php if(!empty($selected) && $selected == 'mymenu') echo ' class="selected"'; ?>>
                                <a href="/users/<?=htmlspecialchars($_SESSION['username'])?>">
                                    <span class="icon-container">
                                        <img src="<?=getAvatar($_SESSION['avatar'], $_SESSION['has_mh'], 0)?>" alt="User Page">
                                    </span>
                                    <span>User Page</span>
                                </a>
                            </li>
                            <li id="global-menu-feed"<?php if(!empty($selected) && $selected == 'feed') echo ' class="selected"'; ?>>
                                <a href="/" class="symbol">
                                    <span>Feed</span>
                                </a>
                            </li>
                            <li id="global-menu-community"<?php if(!empty($selected) && $selected == 'community') echo ' class="selected"'; ?>>
                                <a href="/communities" class="symbol">
                                    <span>Communities</span>
                                </a>
                            </li>
                            <li id="global-menu-message"<?php if(!empty($selected) && $selected == 'message') echo ' class="selected"'; ?>>
                                <a href="/news/messages" class="symbol">
                                    <span>Messages</span>
                                    <?php 
                                    //This is temporary until I figure out how fucking complete-en.js works.
                                    $stmt = $db->prepare('SELECT id, COUNT(*) FROM conversations WHERE (source = ? OR target = ?) AND id IN (SELECT conversation FROM messages WHERE seen = 0 AND conversation = conversations.id AND created_by != ?)');
                                    $stmt->bind_param('iii', $_SESSION['id'], $_SESSION['id'], $_SESSION['id']);
                                    $stmt->execute();
                                    $mcres = $stmt->get_result();
                                    $mcrow = $mcres->fetch_array();
                                    if($mcrow['COUNT(*)'] > 0 && (!isset($selected) || $selected != 'message')) { ?>
                                        <span class="badge" style="display: block;"><?=$mcrow['COUNT(*)']?></span>
                                    <?php }
                                ?>
                                </a>
                            </li>
                            <li id="global-menu-news"<?php if(!empty($selected) && $selected == 'news') echo ' class="selected"'; ?>>
                                <a href="/news/my_news" class="symbol"></a>
                            </li>
                            <li id="global-menu-my-menu">
                                <button class="symbol js-open-global-my-menu open-global-my-menu" id="my-menu-btn"></button>
                                <menu id="global-my-menu" class="invisible none">
                                    <li><a href="/settings/profile" class="symbol my-menu-profile-setting"><span>Profile Settings</span></a></li>
                                    <li><a href="/settings/themes" class="symbol my-menu-miiverse-setting"><span>Theme Settings</span></a></li>
                                    <li><a href="/settings/account" class="symbol my-menu-miiverse-setting"><span>Account Settings</span></a></li>
                                    <li><a href="/my_blacklist" class="symbol my-menu-miiverse-setting"><span>Blocked Users</span></a></li>
                                    <li><a href="/rules" class="symbol my-menu-guide"><span>Site Rules</span></a></li>
                                    <li><a href="/contact" class="symbol my-menu-guide"><span>Contact Us</span></a></li>
                                    <li>
                                        <form action="/logout" method="post" id="my-menu-logout" class="symbol">
                                            <input type="hidden" name="token" value="<?=$_SESSION['token']?>">
                                            <input type="submit" value="Log Out">
                                        </form>
                                    </li>
                                </menu>
                            </li>
                    <?php } ?>
                </menu>
            </div>
            <div id="main-body">