<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Hỗ Trợ Khách Hàng - BT Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fdfdfd;
    }
    .support-header {
      background-color: #f8f9fa;
      padding: 40px 0;
      text-align: center;
    }
    .faq-section h5 {
      cursor: pointer;
    }
  </style>
</head>
<body>

<!-- Header -->
<div class="support-header">
  <h1>Hỗ Trợ Khách Hàng</h1>
  <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn!</p>
</div>

<!-- Liên hệ -->
<div class="container my-5">
  <div class="row">
    <!-- Thông tin liên hệ -->
    <div class="col-md-6">
      <h4>Thông tin liên hệ</h4>
      <p><strong>Email:</strong> hotro@btshop.vn</p>
      <p><strong>Hotline:</strong> 0788546664 </p>
      <p><strong>Địa chỉ:</strong> ổ chịch siu cấp vũ trụ, phường Ghềnh Ráng, TP Qui Nhơn, Tỉnh Bình Định</p>
    </div>

    <!-- Form liên hệ -->
    <div class="col-md-6">
      <h4>Gửi yêu cầu hỗ trợ</h4>
      <form>
        <div class="mb-3">
          <label for="hoten" class="form-label">Họ tên</label>
          <input type="text" class="form-control" id="hoten" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
          <label for="noidung" class="form-label">Nội dung hỗ trợ</label>
          <textarea class="form-control" id="noidung" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
      </form>
    </div>
  </div>
</div>

<!-- FAQ -->
<div class="container my-5 faq-section">
  <h3 class="mb-4">Câu hỏi thường gặp</h3>
  <div class="accordion" id="faqAccordion">
    <div class="accordion-item">
      <h2 class="accordion-header" id="faq1">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#answer1">
          Làm thế nào để đổi/trả hàng?
        </button>
      </h2>
      <div id="answer1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Quý khách có thể đổi/trả hàng trong vòng 7 ngày kể từ khi nhận hàng, với điều kiện sản phẩm còn nguyên tem mác và chưa qua sử dụng.
        </div>
      </div>
    </div>
    
    <div class="accordion-item">
      <h2 class="accordion-header" id="faq2">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#answer2">
          Tôi có thể theo dõi đơn hàng ở đâu?
        </button>
      </h2>
      <div id="answer2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Bạn có thể theo dõi tình trạng đơn hàng tại mục "Đơn hàng của tôi" sau khi đăng nhập tài khoản.
        </div>
      </div>
    </div>
    
    <div class="accordion-item">
      <h2 class="accordion-header" id="faq3">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#answer3">
          BT Shop có giao hàng toàn quốc không?
        </button>
      </h2>
      <div id="answer3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Có. Chúng tôi giao hàng toàn quốc với thời gian từ 2–5 ngày làm việc.
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="text-center py-4 bg-light mt-5">
  <p>&copy; 2025 BT Shop | Hỗ trợ bởi nhân viên cấp quốc tế của BT Shop</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
