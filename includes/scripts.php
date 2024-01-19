<script src="dist/js/app.js"></script>
<script>
var currentUrl = window.location.pathname.split('/').pop();
var menuItems = document.querySelectorAll('.enumenu_ul li a');
console.log(menuItems);
menuItems.forEach(function(link) {
    console.log(link.getAttribute('href'));
    console.log(currentUrl);
    if (link.getAttribute('href') === currentUrl) {
        link.classList.add('active');
    }
});
</script>