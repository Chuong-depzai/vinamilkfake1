-- Tạo database
CREATE DATABASE IF NOT EXISTS vinamilk1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE vinamilk1;

-- Tạo bảng products
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  price FLOAT NOT NULL,
  image VARCHAR(255) NOT NULL,
  type VARCHAR(100) NOT NULL,
  description TEXT,
  ingredients TEXT,
  packaging VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu
INSERT INTO products (name, price, image, type, description, ingredients, packaging) VALUES
('Optimum Gold (trên 1 tuổi)', 462914, 'optimum-gold-1.jpg', 'Sữa bột trẻ em', 'Lúc này hầu hết các dưỡng chất thuộc tim tâm sinh công thức Optimum Gold cũng ở HMO dầu tiên tại Việt Nam, giúp xây dựng hệ miễn dịch, tăng đề kháng và phát triển não bộ. Đạt tiêu chuẩn tính khiết an toàn Purity Award của Clean Label Project từ Hoa Kỳ với 200 lượt kiểm nghiệm khắt khc.', 'Sữa (92,5%) (sữa tươi, nước, sữa bột, chất béo sữa), đường, maltodextrin, dầu thực vật, chất nhũ hóa (E471, E322(i)), khoáng chất, vitamin', 'Hộp',
'YokoGold + (trên 1 tuổi)', 461394, 'yokogold-1.jpg', 'Sữa bột trẻ em', 'Sữa mạch shuẩn Nhật (***) YOKOGOLD vi siêu dạnh chất IQ và kứ dưỡng chất IQ & EQ giúp não đạc định hướng về tiêu hội & hệ dưỡng chất IQ & EQ lượn vé các dành chất hóa học ở thể giá để tốt nhất', 'Sữa bột, maltodextrin, đường, dầu thực vật, DHA, vitamin, khoáng chất', 'Hộp'),
('YokoGold + 3 (2-6 tuổi)', 434074, 'yokogold-3.jpg', 'Sữa bột trẻ em', 'Lúc vần hóng trẻ này mọi, cần mạt YokoGold được xung dần cao lượng đặm MFGM để ké lượp náo, tăng tỷ lệ cao mạnh của ké ở chất khóc khớp hóa học ở năm', 'Sữa bột, maltodextrin, đường, dầu thực vật, MFGM, DHA, vitamin, khoáng chất', 'Hộp'),
('Dielac Gold (trên 1 tuổi)', 399583, 'dielac-gold-1.jpg', 'Sữa bột trẻ em', 'Công thức chuyển biệt với 34 dưỡng chất hỗ trợ bé lớn kỳ, cao hơn, tăng đề kháng và phát triển não bộ. Đạt tiêu chuẩn tính khiết an toàn Purity Award của Clean Label Project từ Hoa Kỳ với 200 lượt kiểm nghiệm khắt khc.', 'Sữa (92,5%) (sữa tươi, nước, sữa bột, chất béo sữa), đường, maltodextrin, dầu thực vật, chất nhũ hóa (E471, E322(i))', 'Hộp'),
('Sữa Tươi Vinamilk 100% Không Đường', 8900, 'sua-tuoi-khong-duong.jpg', 'Sữa tươi', 'Sữa tươi tiệt trùng 100% từ sữa bò tươi nguyên chất, không đường, giàu dinh dưỡng tự nhiên, giúp bổ sung canxi và protein cho cơ thể.', 'Sữa tươi 100%', 'Hộp'),
('Sữa Chua Uống Vinamilk Có Đường', 5500, 'sua-chua-uong-duong.jpg', 'Sữa chua', 'Sữa chua uống có đường với hương vị thơm ngon, cung cấp lợi khuẩn probiotic tốt cho hệ tiêu hóa và sức khỏe đường ruột.', 'Sữa tươi, đường, men sữa chua', 'Chai'),
('Sữa Đặc Có Đường Ông Thọ', 28000, 'sua-dac-ong-tho.jpg', 'Sữa đặc', 'Sữa đặc có đường Ông Thọ với hương vị đậm đà, ngọt ngào, thích hợp dùng để pha chế đồ uống hoặc làm nguyên liệu cho các món tráng miệng.', 'Sữa tươi, đường', 'Lon'),
('Vinamilk Green Farm', 9500, 'green-farm.jpg', 'Sữa tươi', 'Sữa tươi tiệt trùng Green Farm từ trang trại bò sữa organic, không chất bảo quản, giàu dưỡng chất tự nhiên.', 'Sữa tươi organic 100%', 'Hộp'),
('Sữa Bột Dielac Alpha Gold', 485000, 'dielac-alpha-gold.jpg', 'Sữa bột người lớn', 'Sữa bột dinh dưỡng dành cho người lớn tuổi và người cần bổ sung dinh dưỡng, giàu protein, canxi và các vitamin thiết yếu.', 'Sữa bột, maltodextrin, đường, vitamin, khoáng chất', 'Hộp'),
('Sữa Chua Vinamilk Không Đường', 5000, 'sua-chua-khong-duong.jpg', 'Sữa chua', 'Sữa chua không đường với lợi khuẩn probiotic, giúp cải thiện hệ tiêu hóa, phù hợp cho người ăn kiêng và người tiểu đường.', 'Sữa tươi, men sữa chua', 'Hộp');