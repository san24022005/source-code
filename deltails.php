<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết sản phẩm</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
  <div class="row">
    <div class="col-md-5">
      <img src="duongdan_anh_sanpham.jpg" alt="Áo Polo" class="img-fluid">
    </div>
    <div class="col-md-7">
      <h2>Áo Polo Co Giãn - Mã SP: POLO123</h2>
      <p><strong>Loại (danh mục):</strong> Áo Polo</p>
      
      <!-- KIEU sẽ thay đổi ở đây -->
      <p><strong>Kiểu:</strong> <span id="kieuSP">Slim Fit</span></p>

      <p><strong>Nước sản xuất:</strong> Việt Nam</p>
      <p><strong>Giá:</strong> <span class="text-danger fw-bold">499.000₫</span></p>
      
      <form>
        <div class="mb-3">
          <label for="size">Chọn size:</label>
          <select id="size" class="form-select">
            <option value="">--Chọn size--</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
          </select>
        </div>
      </form>
      
      <p><strong>Mô tả:</strong> Áo polo nam chất liệu cotton, thoáng mát, phù hợp đi làm và đi chơi.</p>
    </div>
  </div>
</div>

<script>
  const kieuTheoSize = {
    "S": "Slim Fit",
    "M": "Regular Fit",
    "L": "Loose Fit",
    "XL": "Oversized"
  };

  document.getElementById('size').addEventListener('change', function () {
    const selectedSize = this.value;
    const kieu = kieuTheoSize[selectedSize] || 'Chưa chọn';
    document.getElementById('kieuSP').textContent = kieu;
  });
</script>
</body>
</html>
