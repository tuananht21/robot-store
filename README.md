# Robot Store
Dự án robot store là một website thương mại điện tử được xây dựng để làm project kết thúc học phần môn học với các tính năng nổi bật
như hỗ trợ chat chăm sóc khách hàng real time cơ bản giữa user và admin, thanh toán bằng VNPay sandbox test, hãy cùng nhau xây dựng
và khám phá:

## 📁 Cấu trúc thư mục

```text
robot-store/
├── app/                # Controllers, Models, Events, Job...
├── bootstrap/
├── config/             # Cấu hình ứng dụng (reverb, services, ...)
├── database/           # Migrations, factories, seeders
├── public/             # Entry point, assets đã build
├── resources/
│   ├── css/
│   ├── js/             # Cấu hình Echo/Reverb, Alpine.js
│   └── views/          # Blade templates
├── routes/             # web.php, api.php, channels.php, admin.php
├── tests/
├── composer.json
├── package.json
└── vite.config.js
```

## 📋 Yêu cầu hệ thống
 
Cần cài sẵn các công cụ sau trước khi cài đặt dự án:
 
| Công cụ | Phiên bản | Link tải |
|---------|-----------|----------|
| **XAMPP** (PHP + MySQL) | PHP 8.2 trở lên | [apachefriends.org](https://www.apachefriends.org/) |
| **Composer** | 2.x | [getcomposer.org](https://getcomposer.org/download/) |
| **Node.js** (kèm npm) | 18 trở lên (bản LTS) | [nodejs.org](https://nodejs.org/en/download) |
| **Git** | Bản mới nhất | [git-scm.com](https://git-scm.com/install/windows) |

### 📦 Hướng dẫn cài đặt
 
```bash
git clone https://github.com/tuananht21/robot-store.git
cd robot-store
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate 
npm install
```