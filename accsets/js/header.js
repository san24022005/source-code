var header = document.getElementById('header');
var tabletMenu = document.getElementById('menu-tablet');
var headerHeight = header.clientHeight;

tabletMenu.onclick = function() {
    var isClose = header.clientHeight === headerHeight;

    if (isClose) {
        header.style.height = 'auto';
    }
    else {
        header.style.height = null;
    }
}

var menuItems = document.querySelectorAll('.nav li a[href*="#"]');

for (var i=0; i<menuItems.length; i++){
    var menuItem = menuItems[i];

    menuItem.onclick = function() {
        header.style.height = null;
    }
}

var settingBtn = document.querySelector('.setting-toggle');
var subSetting = document.querySelector('.sub-setting');

settingBtn.onclick = function (e) {
    e.stopPropagation(); // Ngăn lan ra ngoài
    subSetting.classList.toggle('show');
};

// Ngăn đóng khi click vào chính subSetting
subSetting.onclick = function (e) {
    e.stopPropagation();
};

// Đóng khi click ngoài vùng setting
document.addEventListener('click', function () {
    subSetting.classList.remove('show');
});


