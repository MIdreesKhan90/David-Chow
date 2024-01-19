<?php
function is_ajax_request() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

if (is_ajax_request()) {
    include 'includes/generate_gallery.php';
    exit;  // Stop further execution, important to prevent returning the full page
}

?>

<html lang="en">
<?php require 'includes/head.php' ?>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<body>
<?php include 'includes/navbar.php' ?>

<section class="gallery-filter">
    <div class="container">
        <h2 class="title">Humanitarian Award Recipients</h2>
        <!-- Search bar, filter, and sorting options -->
        <form id="filterForm" class="filter-form" onsubmit="event.preventDefault(); updateGallery();">
            <input class="search-input"
                   type="text"
                   name="search_name"
                   placeholder="Search.."
                   value=""
                   onchange="updateGallery()">
            <select class="search-select search-year" name="year_filter">
                <option value="">Filter by: Years</option>
                <?php for ($year = 2015; $year <= 2020; $year++): ?>
                    <option value=".year-<?php echo $year; ?>"><?php echo $year; ?></option>
                <?php endfor; ?>
            </select>
            <select class="search-select sort-by-name" name="sort_option">
                <option value="first_name">Sort by: First Name</option>
                <option value="last_name">Sort by: Last Name</option>
            </select>
        </form>

    </div>
</section>
<section class="section-gallery">
    <div class="container">
        <div id="main-content" class="grid">
            <?php include 'includes/generate_gallery.php'; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php' ?>
<?php require 'includes/scripts.php' ?>

<script>
    function updateGallery() {
        var xhr = new XMLHttpRequest();
        var formData = new FormData(document.getElementById('filterForm'));

        xhr.open('POST', 'recipients-gallery.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        xhr.onload = function() {
            if (this.status == 200) {
                // Replace the content of main-content div with new content
                document.getElementById('main-content').innerHTML = this.responseText;
            } else {
                console.error("Server responded with status:", this.status);
            }
        };
        xhr.onerror = function() {
            console.error("Request failed");
        };
        xhr.send(formData);
    }

</script>

<script>
    // external js: isotope.pkgd.js

    // init Isotope
    var iso = new Isotope( '.grid', {
        itemSelector: '.grid-item',
        layoutMode: 'fitRows',
        getSortData: {
            first_name: '[data-first-name]',
            last_name: '[data-last-name]'
        }
    });

    // filter functions
    var filterFns = {
        // show if number is greater than 50
        numberGreaterThan50: function( itemElem ) {
            var number = itemElem.querySelector('.number').textContent;
            return parseInt( number, 10 ) > 50;
        },
        // show if name ends with -ium
        ium: function( itemElem ) {
            var name = itemElem.querySelector('.name').textContent;
            return name.match( /ium$/ );
        }
    };

    var searchInput = document.querySelector('.search-input');

    searchInput.addEventListener('input', function() {
        var searchText = searchInput.value.toLowerCase();
        iso.arrange({
            filter: function(itemElem) {
                var name = itemElem.getAttribute('data-full-name');
                return name.toLowerCase().includes(searchText);
            }
        });
    });


    var searchYear = document.querySelector('.search-year');
    searchYear.addEventListener( 'change', function() {
        // get filter value from option value
        var filterValue = this.value;
        // use filterFn if matches value
        filterValue = filterFns[ filterValue ] || filterValue;
        iso.arrange({ filter: filterValue });
    });
    document.querySelector('.sort-by-name').addEventListener('change', function(event) {
        var sortByValue = event.target.value;
        iso.arrange({ sortBy: sortByValue });
    });


</script>

</body>
</html>
