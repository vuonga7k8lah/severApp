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