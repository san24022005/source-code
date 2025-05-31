<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liên hệ - Hỗ trợ khách hàng</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: "Segoe UI", sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 40px;
    }

    .contact-section {
      display: flex;
      background: white;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      border-radius: 8px;
      overflow: hidden;
      max-width: 1200px;
      margin: 0 auto;
    }

    .contact-left {
      background-color: #009eff;
      color: white;
      padding: 40px;
      width: 40%;
    }

    .contact-left h2 {
      font-size: 32px;
      margin-bottom: 30px;
    }

    .contact-block {
      display: flex;
      gap: 15px;
      margin-bottom: 30px;
    }

    .contact-block img {
      width: 36px;
      height: 36px;
    }

    .contact-block a {
      color: white;
      text-decoration: underline;
    }

    .contact-right {
      width: 60%;
      padding: 40px;
    }

    .contact-right h2 {
      font-size: 28px;
      margin-bottom: 20px;
      color: #111;
    }

    .contact-form label {
      font-weight: bold;
      margin-top: 15px;
      display: block;
    }

    .contact-form input,
    .contact-form select,
    .contact-form textarea {
      width: 100%;
      padding: 12px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
      resize: vertical;
    }

    .input-row {
      display: flex;
      gap: 20px;
    }

    .input-group {
      flex: 1;
    }

    .phone-input {
      display: flex;
      gap: 10px;
    }

    .contact-form textarea {
      height: 100px;
    }

    .contact-form button {
      background-color: #009eff;
      color: white;
      padding: 14px 24px;
      border: none;
      border-radius: 6px;
      margin-top: 20px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .contact-form button:hover {
      background-color: #007acc;
    }
  </style>
</head>
<body>

<div class="contact-section">
  <!-- LEFT COLUMN -->
  <div class="contact-left">
    <h2>Liên hệ - Hỗ trợ </h2>
    <div class="contact-block">
      <img src="accsets/images/phone-icon.png" alt="Phone">
      <div>
        <strong>Phòng Kinh doanh</strong><br>
        <a href="mailto:hotrobtshop@gmail.com.vn">hotrobtshop@gmmail.com.vn </a><br>
        +84 28 3995 1060 (Mr. Vương)<br>
        +84 78 5666 04530453 (Mr. Hiếu)
      </div>
    </div>
    <div class="contact-block">
      <img src="accsets/images/info-icon.png" alt="Info">
      <div>
        <strong>Yêu Cầu Chung</strong><br>
        +84 28 3997 8000<br>
        Line. 1800 2222 (tuyển dụng)<br>
        Line. 1900 3355 (liên hệ chung)
      </div>
    </div>
    <div class="contact-block">
      <img src="accsets/images/location-icon.png" alt="Location">
      <div>
        <strong>Tòa nhà opera house BT shop </strong><br>
        08 An Dương Vương,Phường Nguyễn Văn Cừ, TP Quy Nhơn, tỉnh Bình Định ,<br>
        Quy Nhơn, Bình Định <a href="#">(Bản đồ)</a>
      </div>
    </div>
  </div>
  <div class="contact-right">
    <h2>Hỗ trợ khách hàng</h2>
    <form class="contact-form">
      <label for="name">Họ và tên *</label>
      <input type="text" id="name" placeholder="Nhập họ và tên">
      <div class="input-row">
        <div class="input-group">
          <label for="email">Email *</label>
          <input type="email" id="email" placeholder="example@mail.com">
        </div>
        <div class="input-group">
          <label for="phone">Số điện thoại</label>
          <div class="phone-input">
            <select>
              <option>(+84)</option>
              <option>(+1)</option>
              <option>(+61)</option>
            </select>
            <input type="text" placeholder="28 3997 8000">
          </div>
        </div>
      </div>
      <label for="company">Shop *</label>
      <input type="text" id="company" placeholder="BT shop">
      <label for="message">Nội dung *</label>
      <textarea id="message" placeholder="Nhập nội dung"></textarea>
      <button type="submit">Gửi →</button>
    </form>
  </div>
</div>
</body>
</html>
