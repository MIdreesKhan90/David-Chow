<?php
function create_slug($string)
{
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
    return trim($slug, '-');
}

// Read the contents of the recipients.json file
$json = file_get_contents('recipients.json');

// Decode the JSON content to a PHP array
$data = json_decode($json, true);

$recipients = isset($data['recipients']) ? $data['recipients'] : [];

$searchName = $_POST['search_name'] ?? '';
$yearFilter = $_POST['year_filter'] ?? '';
$sortOption = $_POST['sort_option'] ?? 'first_name';

// Filter by name and year
if ($searchName) {
    $recipients = array_filter($recipients, function ($recipient) use ($searchName) {
        return stripos($recipient['name'], $searchName) !== false;
    });
}
if ($yearFilter) {
    $recipients = array_filter($recipients, function ($recipient) use ($yearFilter) {
        return $recipient['year'] == $yearFilter;
    });
}

// Ensure recipients is an array before sorting
if (is_array($recipients)) {
    // Sort by first name or last name
    usort($recipients, function ($a, $b) use ($sortOption) {
        $nameA = explode(' ', $a['name']);
        $nameB = explode(' ', $b['name']);

        $sortNameA = ($sortOption == 'last_name' && count($nameA) > 1) ? end($nameA) : $nameA[0];
        $sortNameB = ($sortOption == 'last_name' && count($nameB) > 1) ? end($nameB) : $nameB[0];

        return strcmp($sortNameA, $sortNameB);
    });
}

$counter = 0;  // To keep track of how many recipients have been added to the current row
foreach ($recipients as $recipient) {
    if ($recipient['isActive']) { // Only display active recipients
        $recipient_slug = create_slug($recipient['name']);
        $full_name = explode(' ', $recipient['name']);
        ?>
        <div class="grid-item year-<?php echo $recipient['year']; ?>"
             data-full-name="<?php echo $recipient['name'] ?>"
             data-first-name="<?php echo $full_name[0] ?>"
             data-last-name="<?php echo $full_name[1] ?? '' ?>">
            <!-- Image with Year Overlay at the bottom -->
            <div class="image-container">
                <a href="recipient-details.php?slug=<?php echo $recipient_slug; ?>">
                    <img src="<?php echo $recipient['image']; ?>" alt="<?php echo $recipient['name']; ?>">
                </a>
                <div class="year-overlay">
                    <?php echo $recipient['year']; ?>
                </div>
            </div>
            <h4 class="title">
                <a href="recipient-details.php?slug=<?php echo $recipient_slug; ?>">
                    <?php echo $recipient['name'] ?>
                </a>
            </h4>
        </div>
        <?php
        $counter++;
    }
}
?>
