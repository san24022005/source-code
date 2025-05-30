function updateRowspan() {
  const td = document.getElementById("responsive-shopping");
  if (window.innerWidth <= 660) {
    td.rowSpan = 1; // Mobile
  } else {
    td.rowSpan = 6; // PC
  }
}

// Gọi hàm khi tải trang và khi thay đổi kích thước màn hình
window.addEventListener("load", updateRowspan);
window.addEventListener("resize", updateRowspan);