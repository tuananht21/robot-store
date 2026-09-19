export function formatDate(isoString) {
  // Tạo object Date từ chuỗi ISO
  const date = new Date(isoString);

  // Tùy chọn định dạng
  const options = {
    timeZone: 'Asia/Ho_Chi_Minh', // múi giờ Việt Nam
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
  }

  // Chuyển đổi sang chuỗi định dạng Việt Nam
  return new Intl.DateTimeFormat('vi-VN', options).format(date);
}