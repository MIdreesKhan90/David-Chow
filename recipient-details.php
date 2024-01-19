<?php
// Read the contents of the recipients.json file
$json = file_get_contents('recipients.json');

// Decode the JSON content to a PHP array
$data = json_decode($json, true);

$recipients = isset($data['recipients']) ? $data['recipients'] : [];

$slug = $_GET['slug'] ?? '';

$recipient = null;

foreach ($recipients as $r) {
    if (create_slug($r['name']) === $slug) {
        $recipient = $r;
        break;
    }
}

if (!$recipient) {
    die("Recipient not found.");
}

function create_slug($string) {
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
    return trim($slug, '-');
}

$title = $recipient['name'];
?>
<html lang="en">
<?php require 'includes/head.php' ?>

<body>
<?php include 'includes/navbar.php' ?>

<section class="recipient-details-header">
    <div class="container">
        <a class="back-link" href="./recipients-gallery">Back to Recipients</a>
        <div class="image-container">
            <div class="avatar">
                <img src="<?php echo $recipient['image']; ?>" alt="<?php echo $recipient['name']; ?>">
                <div class="year-overlay">
                    <?php echo $recipient['year']; ?>
                </div>
            </div>
            <h4 class="title"><?php echo $recipient['name']; ?></h4>
        </div>
    </div>
</section>
<section class="inner-content">
    <div class="container">
        <div class="recipient-details">
            <!-- Name below the image -->
            <h2>The David Chow Humanitarian <?php echo $recipient['year']; ?> Award</h2>
            <p><?php echo $recipient['bio']; ?></p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php' ?>
<?php require 'includes/scripts.php' ?>

</body>

</html>
