<?php
/**
 * @var $aRoute severApp\Core\Route
 */
$aRoute->get('token', 'severApp\Controllers\Token\HandleTokenController@test');
$aRoute->get('products', 'severApp\Controllers\Product\ProductController@getProducts');
/** Quản Lý  User
 * $aData {
 * ID cần khi update và delete
 * TenTang string
 * SoPhong là số phòng cs trong tầng int
 * TrangThai trạng thái tầng đang hoạt động hay sửa
 * }
 */
$aRoute->get('users', 'severApp\Controllers\User\AccountController@getAllUser');
$aRoute->post('createUsers', 'severApp\Controllers\User\AccountController@registerUser');
$aRoute->post('updateUsers', 'severApp\Controllers\User\AccountController@updateUser');
$aRoute->post('deleteUsers', 'severApp\Controllers\User\AccountController@deleteUser');
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
/** Quản Lý Thanh Toán
 * $aData {
 * ID cần khi update và delete
 * IDPhong int
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
$aRoute->post('createPay', 'severApp\Controllers\Pay\PayController@registerPay');
$aRoute->post('updatePay', 'severApp\Controllers\Pay\PayController@updatePay');
$aRoute->post('deletePay', 'severApp\Controllers\Pay\PayController@deletePay');

