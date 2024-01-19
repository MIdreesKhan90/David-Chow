<?php
$basePath = '/davidchow';
$scriptName = $_SERVER["SCRIPT_NAME"];

$switchToScript = str_replace($basePath, '', $scriptName);

switch ($switchToScript) {
    case "/about-david-chow.php":
        $PAGE_TITLE = "About | David Chow";
        $PAGE_DESC = "about Desc";
        break;
    case "/recipients-gallery.php":
        $PAGE_TITLE = "Recipients’ Gallery | David Chow";
        $PAGE_DESC = "Gallary Desc";
        break;
    case "/trustees.php":
        $PAGE_TITLE = "Trustees | David Chow";
        $PAGE_DESC = "Trustees Desc";
        break;
    case "/nominations.php":
        $PAGE_TITLE = "Nominations | David Chow";
        $PAGE_DESC = "Nomination Desc";
        break;
    case "/nomination-form.php":
        $PAGE_TITLE = "Nomination Form | David Chow";
        $PAGE_DESC = "Nomination Desc";
        break;
    case "/endorsement-form.php":
        $PAGE_TITLE = "Endorsement Form | David Chow";
        $PAGE_DESC = "Nomination Desc";
        break;
    case "/the-center.php":
        $PAGE_TITLE = "The Center | David Chow";
        $PAGE_DESC = "Center Desc";
        break;
    case "/contact-us.php":
        $PAGE_TITLE = "Contact Us | David Chow";
        $PAGE_DESC = "Contact Us Desc";
        break;
    default:
        $PAGE_TITLE = $title ?? "Home | David Chow";
        $PAGE_DESC = "Welcome to our website";
}
$PHP_SELF = htmlspecialchars($_SERVER['PHP_SELF']);
