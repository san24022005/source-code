<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giới thiệu BT Shop</title>
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #top {
          z-index: 2;
        }
    </style>
</head>
<body>
    <?php
    require 'site.php';
    load_top();
    load_backbtn();
    ?>

    <div class="intro-container intro-section">
        <h1 class="fw-bold">Chào mừng đến với BT Shop</h1>

        <h2>Giới thiệu về BT Shop</h2>
        <p>
          <strong>BT Shop</strong> là cửa hàng thời trang hiện đại, được thành lập vào <strong>tháng 4 năm 2025</strong> bởi <span class="founder">Hồ Minh Hải, Nguyễn Trung Hiếu, Siu San, Võ Văn Vương</span>.
          Với mục tiêu mang đến phong cách năng động, lịch lãm và chất lượng cao cho khách hàng, BT Shop không ngừng đổi mới và cập nhật những xu hướng mới nhất trong lĩnh vực thời trang.
        </p>
        <h2>Tầm nhìn và sứ mệnh</h2>
        <p>
            Chúng tôi tin rằng thời trang không chỉ là quần áo, mà còn là cách mỗi người thể hiện cá tính, phong thái và vị thế xã hội. Với tầm nhìn trở thành điểm đến hàng đầu cho thời trang hàng hiệu nam tại Việt Nam, BT Shop cam kết đem đến những trải nghiệm mua sắm hoàn hảo nhất, từ chất lượng sản phẩm đến dịch vụ khách hàng.
        </p>
        <p>
        Sứ mệnh của chúng tôi là giúp khách hàng nam tự tin tỏa sáng trong mọi hoàn cảnh – từ công sở, dạo phố đến sự kiện đặc biệt – bằng những sản phẩm thời trang cao cấp, chuẩn xu hướng quốc tế.
        </p>

        <h2>Danh mục sản phẩm phong phú – Tinh tế trong từng lựa chọn</h2>
        <p>
            BT Shop tự hào sở hữu bộ sưu tập đa dạng các mặt hàng thời trang đến từ các thương hiệu nổi tiếng như Lacoste, Ralph Lauren, Tommy Hilfiger, Calvin Klein, Hugo Boss, Gucci, Armani, Burberry… Tất cả đều được chọn lọc kỹ lưỡng và nhập khẩu chính ngạch, đảm bảo 100% chính hãng.
        </p>
        <p>
            Các danh mục sản phẩm nổi bật tại BT Shop bao gồm:
        </p>
        <ul>
            <li>Áo polo hàng hiệu – Sự kết hợp hoàn hảo giữa lịch lãm và năng động.</li>
            <li>Áo sơ mi cao cấp – Phù hợp cho công sở, hội họp và các dịp trang trọng.</li>
            <li>Quần jeans, quần kaki, quần âu hàng hiệu – Form dáng chuẩn, chất liệu bền bỉ.</li>
            <li>Áo khoác, blazer, vest – Đẳng cấp, chỉn chu trong từng đường may.</li>
            <li>Giày dép và phụ kiện – Giày thể thao, giày lười, đồng hồ, thắt lưng, ví da… giúp hoàn thiện phong cách.</li>
            <li>Nước hoa nam chính hãng – Tạo dấu ấn cá nhân đặc trưng cho từng quý ông.</li>
        </ul>

        <h2>Phong cách phục vụ chuyên nghiệp, tận tâm</h2>
        <p>
            Tại BT Shop, chúng tôi không chỉ bán hàng mà còn đồng hành cùng khách hàng xây dựng phong cách riêng. Đội ngũ nhân viên tư vấn của chúng tôi được đào tạo bài bản về gu thẩm mỹ, kiến thức thương hiệu và kỹ năng chăm sóc khách hàng. Từ việc chọn size, phối đồ đến chia sẻ mẹo bảo quản quần áo, chúng tôi luôn lắng nghe và hỗ trợ khách hàng một cách tận tâm, lịch sự.
        </p>
        <p>
            Bên cạnh đó, BT Shop còn cung cấp dịch vụ stylist cá nhân theo yêu cầu – giúp khách hàng chọn lựa trang phục phù hợp với dáng người, sở thích và hoàn cảnh sử dụng.
        </p>

        <h2>Cam kết chất lượng và quyền lợi khách hàng</h2>
        <ul>
            <li>Sản phẩm chính hãng 100% – Có hóa đơn nhập khẩu, tem kiểm định và chính sách hoàn trả rõ ràng.</li>
            <li>Bảo hành chính hãng – Với nhiều sản phẩm, chúng tôi hỗ trợ bảo hành theo chính sách từ nhà cung cấp.</li>
            <li>Đổi trả linh hoạt trong 7 ngày – Miễn phí đổi trả nếu sản phẩm có lỗi từ nhà sản xuất hoặc không vừa size.</li>
            <li>Tư vấn miễn phí – Cả online lẫn trực tiếp tại cửa hàng.</li>
        </ul>
        <p>
            Chúng tôi hiểu rằng mua sắm thời trang không chỉ là tiêu dùng, mà còn là một phần của trải nghiệm sống. Do đó, BT Shop luôn nỗ lực nâng cao dịch vụ, cập nhật xu hướng mới nhất và xây dựng cộng đồng khách hàng trung thành, đam mê thời trang.
        </p>

        <h2>Không gian mua sắm đẳng cấp – Trực tiếp và trực tuyến</h2>
        <p>
            Không chỉ đầu tư vào chất lượng sản phẩm, BT Shop còn chú trọng xây dựng một không gian mua sắm hiện đại, sang trọng và thân thiện tại cửa hàng vật lý. Khách hàng có thể trực tiếp thử đồ trong không gian thoải mái, được hỗ trợ bởi nhân viên tư vấn tận tình.
        </p>
        <p>
            Ngoài ra, BT Shop còn phát triển website bán hàng trực tuyến chuyên nghiệp và hệ thống mạng xã hội (Facebook, Instagram, TikTok) để khách hàng có thể dễ dàng theo dõi sản phẩm mới, chương trình ưu đãi và đặt hàng một cách nhanh chóng. Giao hàng toàn quốc, thanh toán linh hoạt và bảo mật thông tin cá nhân là những ưu tiên hàng đầu của chúng tôi khi vận hành hệ thống online.
        </p>

        <h2>Đồng hành cùng bạn trên hành trình đẳng cấp</h2>
        <p>
            BT Shop không đơn thuần là nơi bán đồ hiệu. Chúng tôi mong muốn trở thành người bạn đồng hành của bạn trên hành trình định hình phong cách sống hiện đại, đẳng cấp và bản lĩnh.
        </p>
        <p>
            Cảm ơn bạn đã tin tưởng, lựa chọn và ủng hộ BT Shop suốt thời gian qua. Chúng tôi cam kết không ngừng cải tiến, sáng tạo và nâng tầm chất lượng để luôn xứng đáng với niềm tin của bạn.
        </p>
        <p><strong>BT Shop – Đẳng cấp không chỉ đến từ thương hiệu, mà còn từ phong cách sống.</strong></p>
        <p class="footer">&copy; 2025 BT Shop.</p>
    </div>
</body>
</html>
