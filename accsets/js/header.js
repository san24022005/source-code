var header = document.getElementById('header');
var tabletMenu = document.getElementById('menu-tablet');
var headerHeight = header.clientHeight;

tabletMenu.onclick = function() {
    var isClose = header.clientHeight === headerHeight;

    if (isClose) {
        header.style.height = 'auto';

        var menuItems = document.querySelectorAll('.nav li a[href*="#"]');

        for (var i=0; i<menuItems.length; i++) {
            var menuItem = menuItems[i];

            menuItem.onclick = function(event) {
                var isSubNav = this.nextElementSibling && this.nextElementSibling.classList.contains('sub-nav');

                if (isSubNav) {
                    event.preventDefault();
                } else {
                    header.style.height = null;
                }
            }
        }
    }
    else {
        header.style.height = null;
    }
}
