<?php
/**
 * @var $aRoute severApp\Core\Route
 */
$aRoute->post('permissions', 'severApp\Controllers\Token\HandleTokenController@verifyTokenRole');
$aRoute->get('products', 'severApp\Controllers\Product\ProductController@getProducts');
/** Quản Lý  User
 * $aData {
 * ID cần khi update và delete
 * username string là tên đăng nhập của user
 * password là password của user
 * HoTen là họ Tên Của User
 * NgaySinh là ngày tên của user định dạng kiểu (1998-04-27)
 * CMT là chứng minh thư
 * DiaChi là địa chỉ của user
 * level là quyền của tài khoản
 * }
 * //reset password
 * cần bắn lên
 * token
 * password cũ
 */
$aRoute->get('users', 'severApp\Controllers\User\AccountController@getAllUser');
$aRoute->post('createUsers', 'severApp\Controllers\User\AccountController@registerUser');
$aRoute->post('updateUsers', 'severApp\Controllers\User\AccountController@updateUser');
$aRoute->post('deleteUsers', 'severApp\Controllers\User\AccountController@deleteUser');
$aRoute->post('renewPassword', 'severApp\Controllers\User\AccountController@renewPassword');
$aRoute->post('verifyPassword', 'severApp\Controllers\User\AccountController@verifyPassword');
$aRoute->post('login', 'severApp\Controllers\User\AccountController@handleLogin');
/** Quản Lý Tạo Tầng
 * $aData {
 * ID cần khi update và delete
 * TenTang string
 * SoPhong là số phòng cs trong tầng int
 * TrangThai trạng thái tầng đang hoạt động hay sửa
 * token thêm sửa xóa phải bắn token lên
 * }
 */
$aRoute->get('floors', 'severApp\Controllers\Floors\FloorsController@getAllFloors');
$aRoute->post('createFloors', 'severApp\Controllers\Floors\FloorsController@registerFloors');
$aRoute->post('updateFloors', 'severApp\Controllers\Floors\FloorsController@updateFloors');
$aRoute->post('deleteFloors', 'severApp\Controllers\Floors\FloorsController@deleteFloors');
/** Quản Lý Tạo Phòng
 * $aData {
 * ID cần khi update và delete
 * IDTang ID của Tầng
 * TenPhong string
 * Gia Giá phòng
 * TrangThai là phòng đã có người đặt hay chưa (có là 1 k là 0)
 * TuSua trạng thái tầng đang hoạt động hay sửa (có là 1 k là 0)
 * token thêm sửa xóa phải bắn token lên
 * }
 */
$aRoute->get('rooms', 'severApp\Controllers\Rooms\RoomsController@getAllRooms');
$aRoute->post('createRooms', 'severApp\Controllers\Rooms\RoomsController@registerRooms');
$aRoute->post('updateRooms', 'severApp\Controllers\Rooms\RoomsController@updateRooms');
$aRoute->post('deleteRooms', 'severApp\Controllers\Rooms\RoomsController@deleteRooms');
$aRoute->post('updateStatusRooms', 'severApp\Controllers\Rooms\RoomsController@updateStatusRooms');
/** Quản Lý Tạo Dịch Vụ
 * $aData {
 * ID cần khi update và delete
 * TenDV string
 * Gia Giá
 * TrangThai là dich vụ có còn hay không (có là 1 k là 0)
 * * token thêm sửa xóa phải bắn token lên
 * }
 */
$aRoute->get('services', 'severApp\Controllers\Service\ServiceController@getAllServices');
$aRoute->post('createServices', 'severApp\Controllers\Service\ServiceController@registerServices');
$aRoute->post('updateServices', 'severApp\Controllers\Service\ServiceController@updateServices');
$aRoute->post('deleteServices', 'severApp\Controllers\Service\ServiceController@deleteServices');
/** Quản Lý Hóa Đơn
 * $aData {
 * ID cần khi update và delete
 * IDPhong int
 * Option (TheoPhong | TheoGio) TheoPhong là Thang Toán Theo Phòng,Còn Lại Là Thanh Toán Theo Giờ
 * -------------------------
 * Thong tin khach hang cần bắn lên:
 * Ten họ tên của khách
 * CMT số chứng minh thư
 * SDT số điện thoại
 * DiaChi địa chỉ khách
 * ------------------
 * DichVu bắn lên các ID của các Dịch Vụ dạng: 1,2,3
 *  token thêm sửa xóa phải bắn token lên
 * }
 */
$aRoute->get('pays', 'severApp\Controllers\Pay\PayController@getAllPay');

//Lấy Thông Tin hóa đơn endpoin: http://127.0.0.1/severApp/pays/12 với 12 là ID hóa đơn
$aRoute->get('pays/', 'severApp\Controllers\Pay\PayController@getOnePay');


$aRoute->post('createPay', 'severApp\Controllers\Pay\PayController@registerPay');
$aRoute->post('updatePay', 'severApp\Controllers\Pay\PayController@updatePay');
$aRoute->post('deletePay', 'severApp\Controllers\Pay\PayController@deletePay');
/** Quản Lý Thanh Toán
 * $aData {
 * ID Là ID của Hóa Đơn
 * ------------------
 *  token phải bắn token lên Để Check
 * }
 */
$aRoute->post('checkoutPay', 'severApp\Controllers\Pay\PayController@checkoutPay');
/** Quản Lý Thống Kê
 * $aData {
 * filter Là mặc định là today
 * các loại filter:today,yesterday,thisWeek,thisMonth,thisWeek,lastMonth
 *
 * ------------------
 *  token phải bắn token lên Để Check phải là admin mới hiển thị
 * }
 */
$aRoute->post('statisticPay', 'severApp\Controllers\Statistic\PaysStatisticController@handleStatisticPay');

