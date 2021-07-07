<?php


namespace severApp\Controllers\Pay;


use Exception;
use severApp\Core\TrainJWT;
use severApp\Helpers\Message;
use severApp\Models\PayModel;
use severApp\Models\RoomsModel;
use severApp\Models\ServiceModel;

class PayController
{
    use TrainJWT;

    public function getAllPay()
    {
        $aDataDV = [];
        $aResponse = PayModel::getAll();
        foreach ($aResponse as $item) {
            $oInfo = json_decode($item[3]);
            $aInfoKhach = [
                'Ten'    => $oInfo->Ten,
                'CMT'    => $oInfo->CMT,
                'SDT'    => $oInfo->SDT,
                'DiaChi' => $oInfo->DiaChi
            ];
            if (!empty($item[5])) {
                $aDV = explode(',', $item[5]);
                for ($i = 0; $i < count($aDV); $i++) {
                    $aResponseDV = ServiceModel::getServiceWithID($aDV[$i]);
                    $aDataDV[] = [
                        'TenDV' => $aResponseDV['TenDV'],
                        'Gia'   => $aResponseDV['Gia']
                    ];
                }
            } else {
                $aDataDV = [];
            }
            $aData[] = [
                'ID'         => $item[0],
                'IDPhong'    => $item[1],
                'IDUser'     => $item[2],
                'InfoKhach'  => $aInfoKhach,
                'DichVu'     => $aDataDV,
                'ThanhToan'  => $item[6],
                'createDate' => $item[7],
            ];
            $aDataDV = [];
        }
        echo Message::success('list data', $aData);
    }

    public function registerPay()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token']) || $this->verifyToken($aData['token'], true)) {
            if (checkValidateData($aData)) {
                $aUserData = $this->decodeJWT($aData['token']);
                $aData['IDUser'] = $aUserData->ID;
                if (!checkIDPhong($aData['IDPhong'])) {
                    echo Message::error('Phòng không tồn tại', 401);
                }
                $aInfoKhach = [
                    'Ten'    => $aData['Ten'],
                    'CMT'    => $aData['CMT'],
                    'SDT'    => $aData['SDT'],
                    'DiaChi' => $aData['DiaChi']
                ];
                $aData['infoKhach'] = json_encode($aInfoKhach);
                if ($aData['Option']==='TheoPhong'){
                    $aData['ThanhToan'] = (int)handlePays($aData['DichVu']) + (int)(RoomsModel::getRoom
                        ($aData['IDPhong'])['Gia']);
                }else{
                    $aData['ThanhToan'] = (int)handlePays($aData['DichVu']);
                }
                $status = PayModel::insert($aData);
                if ($status) {
                    RoomsModel::update($aData['IDPhong'], [
                        'TrangThai' => 1
                    ]);
                    echo Message::success('Create Hóa Đơn Thành Công', []);
                    die();
                }
                echo Message::error('Create Hóa Đơn Không Thành Công', 401);
            } else {
                echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
            }
        } else {
            echo Message::error('User not access', 401);
        }
    }

    public function deletePay()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token']) || $this->verifyToken($aData['token'])) {
            if (checkValidateData($aData)) {
                if (PayModel::isExist($aData['ID'])) {
                    $status = PayModel::delete($aData['ID']);
                    if ($status) {
                        echo Message::success('Delete Hóa Đơn Thành Công', []);
                        die();
                    }
                    echo Message::error('Delete Hóa Đơn Không Thành Công', 401);
                } else {
                    echo Message::error('Hóa Đơn Không Tồn Tại', 401);
                }
            } else {
                echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
            }
        } else {
            echo Message::error('User not access', 401);
        }
    }

    public function updatePay()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token']) || $this->verifyToken($aData['token'], true)) {
            if (checkValidateData($aData)) {
                if (PayModel::isExist($aData['ID'])) {
                    $aUserData = $this->decodeJWT($aData['token']);
                    $aData['IDUser'] = $aUserData->ID;
                    if (!checkIDPhong($aData['IDPhong'])) {
                        echo Message::error('Phòng không tồn tại', 401);
                    }
                    $aData['ThanhToan'] = (int)handlePays($aData['DichVu']) + (int)(RoomsModel::getRoom
                        ($aData['IDPhong'])['Gia']);
                    $status = PayModel::update($aData['ID'], $aData);
                    if ($status) {
                        echo Message::success('Update Hóa Đơn Thành Công', []);
                        die();
                    }
                    echo Message::error('Update Hóa Đơn Không Thành Công', 401);
                } else {
                    echo Message::error('Hóa Đơn Không Tồn Tại', 401);
                }
            } else {
                echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
            }
        } else {
            echo Message::error('User not access', 401);
        }
    }

    public function checkoutPay()
    {
        $aData = $_POST;
        try {
            if ($this->verifyToken($aData['token']) || $this->verifyToken($aData['token'], true)) {
                if (!isset($aData['ID']) || !PayModel::isExist($aData['ID'])) {
                    throw new Exception("ID Hóa Đơn Chưa Tồn Tại", 401);
                }
                if (checkValidateData($aData)) {
                    $option=PayModel::getFields($aData['ID'], 'Option');
                    $aData['IDPhong'] = PayModel::getFields($aData['ID'], 'IDPhong');
                    $aData['IDHoaDon'] = $aData['ID'];
                    if ($option==='TheoPhong'){
                        $aData['TongTien']=(int) PayModel::getFields($aData['ID'], 'ThanhToan');
                    }else{
                        //set thời gian về múi giời HCM
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        //set Giá của 1 giờ bằng tiền phòng 110% giá phòng
                        $priceOneHouse=(int)(RoomsModel::getRoom($aData['IDPhong'])['Gia'])*1.1;
                        //tính Giờ Thanh Đã ở bằng thời gian hiện tại trừ đi thời gian tạo hóa đơn
                        $time = abs(ceil((strtotime(date_format((new \DateTime()),'Y-m-d H:i:s'))-strtotime(PayModel::getFields($aData['ID'], 'createDate')))/3600));
                        $aData['TongTien']=(int)PayModel::getFields($aData['ID'], 'ThanhToan') + $priceOneHouse*$time;

                    }
                    $result = PayModel::insertThanhToan($aData);
                    if ($result) {
                        RoomsModel::update($aData['IDPhong'], [
                            'TrangThai' => 0
                        ]);
                        echo Message::success("Thanh Toán Thành Công");
                        die();
                    }
                    echo Message::error("Thanh Toán Không Thành Công", 401);
                } else {
                    echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
                }
            } else {
                echo Message::error('User not access', 401);
            }
        } catch (Exception $exception) {
            echo Message::error($exception->getMessage(), $exception->getCode());
        }
        ///lấy giờ hiện tại
//        date_default_timezone_set('Asia/Ho_Chi_Minh');
//        var_dump(date('m-d-Y h:i:s a', time()));
    }
}