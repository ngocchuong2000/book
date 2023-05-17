## Cách setup source

B1: tải source từ link git: https://github.com/ngocchuong2000/book.git
vào xampp/htdocs (link tải xampp: https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.4.33/)
B2: mở xampp ở ngoài desktop và start apache, mysql
B3: tạo database tên là "dealbook" và import file dealbook.sql vào
B4: cài composer (link composer: https://getcomposer.org/download/)
B5: vào visual studio code và mở terminal
B6: chạy lệnh "composer install"
B7: chạy lệnh "cp .env.example .env"
B8: chỉnh DB_DATABASE=dealbook ở file .env
B9: chạy lần lượt lệnh "php artisan key:generate", "php artisan storage:link" và "php artisan optimize"
B10: chạy lệnh "php artisan serve" để run website
B11: truy cập link
+ trang user: http://127.0.0.1:8000
+ trang admin và nhân viên: http://127.0.0.1:8000/ad

Lưu ý: chia trình duyệt ra cho trang user và trang admin, nhân viên

tài khoản user: test@gmail.com / 12345678
tài khoản admin: admin@gmail.com / 123456
tài khoản nhân viên: nv@gmail.com / 123456
tài khoản paypal: sb-lpy7v21596571@personal.example.com / #/W8ecXl