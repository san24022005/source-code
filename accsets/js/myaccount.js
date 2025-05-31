function enableEdit() {
    const inputs = document.querySelectorAll("input:not([type=radio])");
    inputs.forEach(el => {
    el.removeAttribute("readonly");
    el.removeAttribute("disabled");
    el.style.backgroundColor = "#fff";
    el.style.cursor = "text";
});
alert("Bạn có thể chỉnh sửa thông tin bây giờ!");
}