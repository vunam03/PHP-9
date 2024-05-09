// Lấy dữ liệu người dùng từ server
function getData() {
    // Tạo một yêu cầu HTTP GET
    const request = new XMLHttpRequest();
    // Thiết lập URL của yêu cầu
    request.open("GET", "/api/users/me");
    // Gửi yêu cầu
    request.send();
  
    // Khi nhận được phản hồi từ server
    request.onload = function() {
      // Nếu yêu cầu thành công
      if (request.status === 200) {
        // Trả về dữ liệu người dùng
        const data = JSON.parse(request.responseText);
  
        // Gán dữ liệu người dùng vào các phần tử DOM
        $("#name").text(data.name);
        $("#email").text(data.email);
        $("#phone").text(data.phone);
        $("#gender").text(data.gender);
        $("#birthdate").text(data.birthdate);
        $("#address").text(data.address);
      }
    };
  }
  
  // Gọi hàm lấy dữ liệu người dùng
  getData();
  