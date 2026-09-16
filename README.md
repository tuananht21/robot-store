# Robot-Store

## Công nghệ sử dụng
- Frontend: Vue.js
- Backend: Laravel
- Database: MySQL

## Yêu cầu trước khi cài đặt
- PHP 8.2
- Composer
- Node.js >= 18
- MySQL

## Hướng dẫn cài đặt

### Frontend (Vue)
```bash
cd frontend
npm install
npm run dev
```

### Backend (Laravel)
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Tác giả
- Trương Hoàng Tuấn Anh