drop database weblightstar;
create database weblightstar;
use weblightstar;

-- 1
-- Cấu trúc bảng cho bảng `user_account`
-- 

CREATE TABLE `user_account` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(15) ,
  `email` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `status` int NOT NULL,
  `role` varchar(10) NOT NULL,
  `create_date` timestamp DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2
-- Cấu trúc bảng cho bảng `product_group`
-- 

CREATE TABLE `product_group` (
  `pg_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `status` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3
-- Cấu trúc bảng cho bảng `product_type`
-- 

CREATE TABLE `product_type` (
  `pt_id` int(11) UNSIGNED NOT NULL,
  `pg_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(65535) COLLATE utf8mb4_unicode_ci,
  `status` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4
-- Cấu trúc bảng cho bảng `promotion`
-- 

CREATE TABLE `promotion` (
  `prom_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percent` float NOT NULL,
  `from_date` timestamp NOT NULL,
  `to_date` timestamp NOT NULL,
  `description` varchar(65535) COLLATE utf8mb4_unicode_ci,
  `image` varchar(100),
  `status` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5
-- Cấu trúc bảng cho bảng `receipt`
-- 

CREATE TABLE `receipt` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `create_date` timestamp DEFAULT NOW(),
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6
-- Cấu trúc bảng cho bảng `image`
-- 

CREATE TABLE `image` (
  `img_id` int(11) UNSIGNED NOT NULL,
  `pro_id` int(11) UNSIGNED NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7
-- Cấu trúc bảng cho bảng `trademark`
-- 

CREATE TABLE `trademark` (
  `tra_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(100) NOT NULL,
  `status` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8
-- Cấu trúc bảng cho bảng `product`
-- 

CREATE TABLE `product` (
  `pro_id` int(11) UNSIGNED NOT NULL,
  `tra_id` int(11) UNSIGNED NOT NULL,
  `prom_id` int(11) UNSIGNED,
  `pt_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `n_rate` float,
  `description` varchar(65535) COLLATE utf8mb4_unicode_ci,
  `status` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9
-- Cấu trúc bảng cho bảng `evalute`
-- 

CREATE TABLE `evalute` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `pro_id` int(11) UNSIGNED NOT NULL,
  `rate` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci,
  `create_date` timestamp DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10
-- Cấu trúc bảng cho bảng `invoice_detail`
-- 

CREATE TABLE `invoice_detail` (
  `id` int(11) UNSIGNED NOT NULL,
  `pro_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `description` varchar(65535) COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11
-- Cấu trúc bảng cho bảng `cart`
-- 

CREATE TABLE `cart` (
  `id` int(11) UNSIGNED NOT NULL,
  `pro_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- #############################################################################################

-- 1
-- Chỉ mục cho bảng `user_account`
-- 

ALTER TABLE `user_account`
  ADD PRIMARY KEY (`user_id`);

-- 2
-- Chỉ mục cho bảng `product_group`
-- 

ALTER TABLE `product_group`
  ADD PRIMARY KEY (`pg_id`);

-- 3
-- Chỉ mục cho bảng `product_type `
-- 

ALTER TABLE `product_type`
  ADD PRIMARY KEY (`pt_id`),
   ADD KEY `product_type_product_group_id_foreign` (`pg_id`);

-- 4
-- Chỉ mục cho bảng `promotion`
-- 

ALTER TABLE `promotion`
  ADD PRIMARY KEY (`prom_id`);

-- 5
-- Chỉ mục cho bảng `receipt `
-- 

ALTER TABLE `receipt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receipt_user_id_foreign` (`user_id`);

-- 6
-- Chỉ mục cho bảng `image`
-- 

ALTER TABLE `image`
  ADD PRIMARY KEY (`img_id`),
  ADD KEY `image_product_id_foreign` (`pro_id`);

-- 7
-- Chỉ mục cho bảng `trademark`
-- 

ALTER TABLE `trademark`
  ADD PRIMARY KEY (`tra_id`);

-- 8
-- Chỉ mục cho bảng `product`
-- 

ALTER TABLE `product`
  ADD PRIMARY KEY (`pro_id`),
  ADD KEY `product_trademark_id_foreign` (`tra_id`),
  ADD KEY `product_promotion_id_foreign` (`prom_id`),
  ADD KEY `product_product_type_id_foreign` (`pt_id`);

-- 9
-- Chỉ mục cho bảng `evalute`
-- 

ALTER TABLE `evalute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evalute_user_id_foreign` (`user_id`),
  ADD KEY `evalute_product_id_foreign` (`pro_id`);

-- 10
-- Chỉ mục cho bảng `invoice_detail`
-- 

ALTER TABLE `invoice_detail`
  ADD KEY `invoice_detail_receipt_id_foreign` (`id`),
  ADD KEY `invoice_detail_product_id_foreign` (`pro_id`);

-- 11
-- Chỉ mục cho bảng `cart`
-- 

ALTER TABLE `cart`
  ADD KEY `cart_user_account_id_foreign` (`id`),
  ADD KEY `cart_product_id_foreign` (`pro_id`);

-- #############################################################################################

-- 
-- AUTO_INCREMENT cho bảng `user_account`
-- 
ALTER TABLE `user_account`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT cho bảng `product_group`
-- 
ALTER TABLE `product_group`
  MODIFY `pg_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT cho bảng `product_type`
-- 
ALTER TABLE `product_type`
  MODIFY `pt_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT cho bảng `promotion`
-- 
ALTER TABLE `promotion`
  MODIFY `prom_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT cho bảng `receipt`
-- 
ALTER TABLE `receipt`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT cho bảng `image`
-- 
ALTER TABLE `image`
  MODIFY `img_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT cho bảng `trademark`
-- 
ALTER TABLE `trademark`
  MODIFY `tra_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT cho bảng `product`
-- 
ALTER TABLE `product`
  MODIFY `pro_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT cho bảng `evalute`
-- 
ALTER TABLE `evalute`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

-- #############################################################################################

-- 
-- Các ràng buộc cho bảng `user_account`
-- 
ALTER TABLE `user_account`
  ADD CHECK(`email` like '%@gmail.com'),
  ADD CHECK(`status` in(0, 1)),
  ADD CHECK(`role` in('user', 'admin'));

-- 
-- Các ràng buộc cho bảng `product_group`
-- 
ALTER TABLE `product_group`
  ADD CHECK(`status` in(0, 1));

-- 
-- Các ràng buộc cho bảng `product_type`
-- 
ALTER TABLE `product_type`
  ADD CHECK(`status` in(0, 1)),
  ADD CONSTRAINT `product_type_product_group_id_foreign` FOREIGN KEY (`pg_id`) REFERENCES `product_group` (`pg_id`);

-- 
-- Các ràng buộc cho bảng `promotion`
-- 
ALTER TABLE `promotion`
  ADD CHECK(`status` in(0, 1)),
  ADD CHECK(`percent` between 0 and 100);

-- 
-- Các ràng buộc cho bảng `receipt`
-- 
ALTER TABLE `receipt`
  ADD CHECK(`status` in(0, 1)),
  ADD CONSTRAINT `receipt_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`);

-- 
-- Các ràng buộc cho bảng `image`
-- 
ALTER TABLE `image`
  ADD CONSTRAINT `image_product_id_foreign` FOREIGN KEY (`pro_id`) REFERENCES `product` (`pro_id`);

-- 
-- Các ràng buộc cho bảng `trademark`
-- 
ALTER TABLE `trademark`
  ADD CHECK(`status` in(0, 1));

-- 
-- Các ràng buộc cho bảng `product`
-- 
ALTER TABLE `product`
  ADD CONSTRAINT `product_trademark_id_foreign` FOREIGN KEY (`tra_id`) REFERENCES `trademark` (`tra_id`),
  ADD CONSTRAINT `product_promotion_id_foreign` FOREIGN KEY (`prom_id`) REFERENCES `promotion` (`prom_id`),
  ADD CONSTRAINT `product_product_type_id_foreign` FOREIGN KEY (`pt_id`) REFERENCES `product_type` (`pt_id`),
  ADD CHECK(`price` > 0),
  ADD CHECK(`quantity` > 0),
  ADD CHECK(`n_rate` between 0 and 5),
  ADD CHECK(`status` in(0, 1));
  
-- 
-- Các ràng buộc cho bảng `evalute`
-- 
ALTER TABLE `evalute`
  ADD CONSTRAINT `evalute_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`),
  ADD CONSTRAINT `evalute_product_id_foreign` FOREIGN KEY (`pro_id`) REFERENCES `product` (`pro_id`),
  ADD CHECK(`rate` > 0 AND `rate` <= 5);
  
-- 
-- Các ràng buộc cho bảng `invoice_detail`
-- 
ALTER TABLE `invoice_detail`
  ADD CONSTRAINT `invoice_detail_receipt_id_foreign` FOREIGN KEY (`id`) REFERENCES `receipt` (`id`),
  ADD CONSTRAINT `invoice_detail_product_id_foreign` FOREIGN KEY (`pro_id`) REFERENCES `product` (`pro_id`),
  ADD CHECK(`quantity` > 0),
  ADD CHECK(`price` > 0);

-- 
-- Các ràng buộc cho bảng `cart`
-- 
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_user_account_id_foreign` FOREIGN KEY (`id`) REFERENCES `user_account` (`user_id`),
  ADD CONSTRAINT `cart_product_id_foreign` FOREIGN KEY (`pro_id`) REFERENCES `product` (`pro_id`),
  ADD CHECK(`quantity` > 0);

-- #############################################################################################

-- 
-- Đang đổ dữ liệu cho bảng `user_account`
-- 

INSERT INTO `user_account` (`name`, `phone_number`, `email`, `password`, `status`, `role`, `create_date`) VALUES
('Nguyễn Bá Trung', '0123456789', 'trung@gmail.com', '$2y$10$Qu306NCl60KeewFyoTrepeaKkFl9kfIyNHue0vWa4IDua2ZKJmHhG', '1', 'admin', '2022-05-06'),
('Đặng Như Hải', '0463856289', 'hai@gmail.com', '1234', '$2y$10$KZDRdMA/fk/yFVN/YjXm5uzx703Jhl8AOeECH.HbNRmV4lnMW2Jn.', 'admin', '2022-05-06'),
('Đặng Thị Ngọc Anh', '0921867046', 'anh1663@gmail.com', '$2y$10$KRKPY2W4UWO0rXsF85sS1OOmJdy9qcFuB922UQqMYgVjNYGF9RD3.', '1', 'user', '2022-05-09'),
('Nguyễn Quang Huy', '0298618493', 'huy100263@gmail.com', '$2y$10$xtTAuQJQVg4/R8pmpUkleua/qXJRnGYr5UZ2wnXtwL1ZOcYmM8yNS', '1', 'user', '2022-05-09');

-- 
-- Đang đổ dữ liệu cho bảng `product_group`
-- 

INSERT INTO `product_group` (`name`, `status`) VALUES
('Laptop & Macbook', 1),
('PC - Máy tính đồng bộ', 1),
('Màn hình máy tính', 1),
('Linh kiện máy tính', 1),
('Hi-End Gaming', 1),
('Phụ kiện & thiết bị ngoại vi', 1),
('Thiết bị âm thanh', 1),
('Máy ảnh - Máy quay phim', 1),
('Thiết bị văn phòng', 1),
('Thiết bị mạng - An ninh', 1);

-- 
-- Đang đổ dữ liệu cho bảng `product_type`
-- 

INSERT INTO `product_type` (`pg_id`, `name`, `description`, `status`) VALUES
(1, 'Laptop theo thương hiệU', '',1),
(1, 'Laptop theo cấu hình chip scat', '',1),
(1, 'Laptop theo kích thước', '',1),
(1, 'Laptop theo nhu cầu', '',1),
(1, 'Laptop theo giá', '',1),
(2, 'PC theo thương hiệu', '',1),
(2, 'PC theo giá', '',1),
(2, 'PC theo nhu cầu', '',1),
(2, 'PC theo cấu hình chip', '',1),
(3, 'Theo thương hiệu', '',1),
(3, 'Độ phân giải', '',1),
(3, 'Theo kích cỡ', '',1),
(3, 'Theo nhu cầu', '',1),
(3, 'Tần số quét', '',1),
(3, 'Theo giá', '',1),
(4, 'CPU - Bộ vi xử lý', '',1),
(4, 'Ổ cứng', '',1),
(4, 'VGA - Card màn hình', '',1),
(4, 'Tản nhiệt', '',1),
(4, 'Case - Thùng máy tính', '',1),
(4, 'Mainboard - Bo mạch chủ', '',1),
(4, 'RAM - Bộ nhớ', '',1),
(4, 'PSU - Nguồn máy tính', '',1),
(5, 'Laptop Gaming', '',1),
(5, 'Màn hình Gaming', '',1),
(5, 'Chuột Gaming', '',1),
(5, 'Tai nghe Gaming', '',1),
(5, 'Bàn phím Gaming', '',1),
(5, 'Lót chuột', '',1),
(5, 'Thiết bị Livestream', '',1),
(5, 'Ghế Gaming', '',1),
(6, 'Bàn phím Gaming', '',1),
(6, 'Chuột Gaming', '',1),
(6, 'Bàn phím văn phòng', '',1),
(6, 'Chuột văn phòng', '',1),
(6, 'Tay cầm chơi game', '',1),
(7, 'Tai nghe', '',1),
(7, 'Loa', '',1),
(8, 'Máy ảnh', '',1),
(8, 'Máy quay phim', '',1),
(8, 'Camera hành trình', '',1),
(8, 'Phụ kiện', '',1),
(9, 'Máy in', '',1),
(9, 'Mực in - Giấy in', '',1),
(9, 'Máy Scan', '',1),
(9, 'Máy Fax', '',1),
(9, 'Thiết bị trình chiếu', '',1),
(9, 'Phần mềm', '',1),
(10, 'Thiết bị mạng', '',1),
(10, 'Thiết bị an ninh', '',1);

-- 
-- Đang đổ dữ liệu cho bảng `promotion`
-- 

-- INSERT INTO `promotion` (`prom_id`, `name`, `percent`, `from_date`, `to_date`, `description`, `image`, `status`) VALUES();

-- 
-- Đang đổ dữ liệu cho bảng `receipt`
-- 

-- INSERT INTO `receipt` (`pt_id`, `pg_id`, `name`, `description`, `status`) VALUES

-- 
-- Đang đổ dữ liệu cho bảng `trademark`
-- 

INSERT INTO `trademark` (`name`, `logo`, `status`) VALUES
('Apple', '', 1),
('Acer', '', 1),
('ASUS', '', 1),
('Dell', '', 1),
('HP', '', 1), -- 5
('Lenovo', '', 1),
('LG', '', 1),
('MSI', '', 1),
('Huawei', '', 1),
('Gigabyte', '', 1), -- 10
('Intel', '', 1), 
('Core i3', '', 1),
('Core i5', '', 1),
('Core i7', '', 1),
('Core i9', '', 1), -- 15
('Ryzen 3', '', 1),
('Ryzen 5', '', 1),
('Ryzen 7', '', 1),
('Ryzen 9', '', 1), 
('Canon', '', 1), -- 20
('Logitech', '', 1),
('Fuhlen', '', 1),
('Router WiFi 6', '', 1),
('SamSung', '', 1),
('Kingston', '', 1), -- 25
('Ổ cứng HDD', '', 1),
('Ổ cứng SSD', '', 1); 

-- 
-- Đang đổ dữ liệu cho bảng `product`
-- 

INSERT INTO `product` (`tra_id`, `pt_id`, `name`, `price`, `quantity`, `image`, `n_rate`, `description`, `status`) VALUES
(1, 1, 'Laptop APPLE MacBook Pro 2021 16" MK183SA/A (16" Apple M1 Pro/16GB/512GB SSD/macOS/2.1kg)', 65990000, 10, '', 5, 'Laptop APPLE MacBook Pro 2021 16" MK183SA/A sở hữu hiệu năng mạnh mẽ với chip M1 Pro cùng với Ram và ổ cứng có dung lượng lớn. Kết hợp cùng thiết kế sang trọng và thời thượng, đây sẽ là chiếc máy tính xách tay đem đến cho bạn những trải nghiệm học và làm việc tuyệt vời nhất.', 1),
(4, 1, 'Laptop Dell Gaming G15 5511 P105F006BGR (15.6" Full HD/ 120Hz/Intel Core i7-11800H/16GB/512GB SSD/NVidIA GeForce RTX 3050Ti/Windows 11 Home SL/2.8kg)', 32990000, 5, '', 4, 'Laptop Dell Gaming G15 5511 P105F006BGR là một trong những mẫu laptop gaming phân khúc tầm trung từ thương hiệu Dell. Với thiết kế sang trọng, mạnh mẽ đậm chất gaming cùng với hiệu năng mạnh mẽ vượt trội, hình ảnh hiển thị chất lượng, đây sẽ là lựa chọn mà bạn không thể bỏ qua.', 1),
(5, 1, 'Laptop HP Envy X360 13-ay1056AU 601Q8PA (13.3" AMD Ryzen 7 5800U/8GB/256GB SSD/Windows 11 Home/1.35kg)', 28490000, 8, '', 5, 'Laptop HP Envy X360 13-ay1056AU (601Q8PA) thuộc dòng laptop cao cấp, với khả năng gập 360 độ có thể biến chiếc laptop của bạn thành một chiếc máy tính bảng có thể thao tác cảm ứng tiện dụng ngay trên màn hình tấm nền IPS cùng đồ họa đỉnh cao, cùng với con chip xử lý ADM ryzen 7 nâng cao hiệu năng hoạt động, hỗ trợ bạn tối đa trong mọi công việc.', 1),
(6, 1, 'Laptop Lenovo Legion 5 Pro 16ITH6H 82JD00BCVN (16" 165Hz/Intel Core i7-11800H/16GB/512GB SSD/NVidIA GeForce RTX 3060/Windows 11 Home/2.3kg)', 39990000, 5, '', 4, 'Laptop Lenovo Legion 5 Pro 16ITH6H-82JD00BCVN nổi bật với cấu hình mạnh mẽ từ Intel Core i7 thế hệ thứ 11, và chip đồ họa NVidIA GeForce RTX 3060, sẵn sàng để đáp ứng cho nhu cầu chơi game hay làm việc với các phần mềm đồ họa của nhiều bạn trẻ hiện nay. ', 1),
(11, 2, 'Máy tính để bàn - PC Intel NUC Kit NUC7i3BNHXF Baby Canyon NUC7i3BNHXF (i3-7100U/4GB/1TB HDD/Iris 620)', 11900000, 3, '', 4, 'Máy tính bàn lắp sẵn PC Intel NUC Kit NUC7i3BNHXF Baby Canyon là thiết bị nằm trong dòng sản phẩm quen thuộc INTEL NUC 7 HOME MINI PC của tập đoàn Intel, cái tên đã rất phổ biến với người dùng cùng hàng loạt những sản phẩm thiết bị điện tử liên quan như chip vi xử lý cho máy tính, bo mạch chủ, ổ nhớ flash, card đồ họa và nhiều thiết bị máy tính khác.', 1),
(19, 4, 'CPU AMD Ryzen 9 5950X (16C/32T, 3.40 GHz - 4.90 GHz, 64MB) - AM4', 20669000, 10, '', 5, 'Đánh giá chi tiết Bộ vi xử lý/ CPU AMD Ryzen 9 5950X. Trang bị lên đến 16 nhân xử lý và 32 luồng, bộ nhớ cache 64Mb. Tốc độ lên đến 4.9Ghz, trang bị nhiều công nghệ xử lý.', 1),
(14, 4, 'CPU INTEL Core i7-12700K (12C/20T, 2.70 GHz - 3.60 GHz, 25MB) - 1700', 10990000, 5, '', 5, 'CPU Intel Core i7-12700K là CPU thế hệ thứ 12 của Intel sở hữu hiệu năng vượt trội, nâng cấp cấu hình dàn PC hiện tại của người dùng lên tầm cao mới. Với nhiều ưu điểm nổi bật, đây là dòng CPU cao cấp đáng để đầu tư nếu bạn muốn trải nghiệm hiệu năng nâng cao ngay hôm nay.', 1),
(20, 8, 'Máy ảnh Canon in liền iNSPiC [S] ZV-123A (Vàng hồng)', 5190000, 6, '', 4, 'Máy ảnh Canon in liền iNSPiC [S] ZV-123A (Trắng) được thiết kế và sản xuất bởi hãng CANON – là một trong những tập đoàn lớn chuyên về thiết kế, phát triển và sản xuất các thiết bị đa phương tiện, thiết bị văn phòng như máy ảnh, máy quay video, máy in, máy photocopy,….. Tập đoàn được thành lập vào năm 1937 và có trụ sở chính được đặt ở Tokyo, Nhật Bản. Các sản phẩm của hãng được người sử dụng đánh gia cao về kiểu dáng mẫu mã cũng như tính năng đem lại.', 1),
(23, 10, 'Thiết bị định tuyến mạng không dây Asus Wifi 6 GT-AX6000', 12449000, 7, '', 5, 'Thiết bị định tuyến mạng không dây Asus GT-AX6000 mang đến hiệu suất đáng kinh ngạc với thiết kế hoàn toàn mới nổi bật. Bộ định tuyến chơi game tương lai cao cấp cho phép các game thủ kết nối nhiều thiết bị hơn và có trải nghiệm chơi game mượt mà hơn bao giờ hết.', 1),
(21, 6, 'Bàn phím cơ Logitech Gaming G813 (Full Size/GL Tactile)', 3189000, 50, '', 5, 'Laptop APPLE MacBook Pro 2021 16" MK183SA/A sở hữu hiBàn phím cơ với một phong cách mới chắc chắn sẽ khiến bạn yêu thích, thiết kế siêu mỏng tinh tế kèm các phím G hoàn toàn có thể tùy chỉnh một cách dễ dàng, đưuọc trang bị đèn LED RGB riêng biệt. Trải nghiệm G813 và chơi game một cách thoải mái nhất.', 1),
(22, 6, 'Bàn phím cơ Fuhlen Destroyer (Full size/Optical Switch/7 màu)', 899000, 100, '', 5, '', 1);
-- 
-- Đang đổ dữ liệu cho bảng `evalute`
-- 

-- INSERT INTO `evalute` (`id`, `user_id`, `pro_id`, `rate`, `comment`, `create_date`) VALUES

-- 
-- Đang đổ dữ liệu cho bảng `cart`
-- 

-- INSERT INTO `cart` (`id`, `pro_id`, `quantity`) VALUES