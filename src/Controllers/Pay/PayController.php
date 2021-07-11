<?php


namespace severApp\Controllers\Pay;


use DateTime;
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

    public function getOnePay($ID)
    {
        if (PayModel::isExist($ID)) {
            $aDataPay = PayModel::getPayWithID($ID);
            if ($aDataPay) {
                echo Message::success('list data', $aDataPay);
                die();
            }
            echo Message::error('sorry, get list data pay error', 401);
        } else {
            echo Message::error('sorry,pay not exist', 401);
        }
    }

    public function registerPay()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token']) || $this->verifyToken($aData['token'], true)) {
            if (checkValidateData($aData)) {
                $aUserData = $this->decodeJWT($aData['token']);
                $aData['IDUser'] = $aUserData->ID;
                if (!checkIDPhong($aData['IDPhong'])) {
                    echo Message::error('Sorry,the room is not exist', 401);
                }
                $aInfoKhach = [
                    'Ten'    => $aData['Ten'],
                    'CMT'    => $aData['CMT'],
                    'SDT'    => $aData['SDT'],
                    'DiaChi' => $aData['DiaChi']
                ];
                $aData['infoKhach'] = json_encode($aInfoKhach);
                if ($aData['Option'] === 'TheoPhong') {
                    $aData['ThanhToan'] = (int)handlePays($aData['DichVu']) + (int)(RoomsModel::getRoom
                        ($aData['IDPhong'])['Gia']);
                } else {
                    $aData['ThanhToan'] = (int)handlePays($aData['DichVu']);
                }
                $ID = PayModel::insert($aData);
                if ($ID) {
                    RoomsModel::update($aData['IDPhong'], [
                        'TrangThai' => 1
                    ]);
                    echo Message::success('The pay create successfully', ['ID' => $ID]);
                    die();
                }
                echo Message::error('The pay create not successfully', 401);
            } else {
                echo Message::error('Sorry,param is not empty', 401);
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
                        echo Message::success('The pay delete successfully', []);
                        die();
                    }
                    echo Message::error('The pay delete not successfully', 401);
                } else {
                    echo Message::error('Sorry,the pay is not exist', 401);
                }
            } else {
                echo Message::error('Sorry,param is not empty', 401);
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
                        echo Message::error('Sorry,the room is not exist', 401);
                    }
                    $aData['ThanhToan'] = (int)handlePays($aData['DichVu']) + (int)(RoomsModel::getRoom
                        ($aData['IDPhong'])['Gia']);
                    $status = PayModel::update($aData['ID'], $aData);
                    if ($status) {
                        echo Message::success('The pay update successfully', []);
                        die();
                    }
                    echo Message::error('The pay delete not successfully', 401);
                } else {
                    echo Message::error('Sorry,param is not empty', 401);
                }
            } else {
                echo Message::error('Sorry,param is not empty', 401);
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
                    $option = PayModel::getFields($aData['ID'], 'Option');
                    $aData['IDPhong'] = PayModel::getFields($aData['ID'], 'IDPhong');
                    $aData['IDHoaDon'] = $aData['ID'];
                    if ($option === 'TheoPhong') {
                        $aData['TongTien'] = (int)PayModel::getFields($aData['ID'], 'ThanhToan');
                    } else {
                        //set thời gian về múi giời HCM
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        //set Giá của 1 giờ bằng tiền phòng 110% giá phòng
                        $priceOneHouse = (int)(RoomsModel::getRoom($aData['IDPhong'])['Gia']) * 1.1;
                        //tính Giờ Thanh Đã ở bằng thời gian hiện tại trừ đi thời gian tạo hóa đơn
                        $time = abs(ceil((strtotime(date_format((new DateTime()), 'Y-m-d H:i:s')) -
                                strtotime(PayModel::getFields($aData['ID'], 'createDate'))) / 3600));
                        $aData['TongTien'] = (int)PayModel::getFields($aData['ID'], 'ThanhToan') +
                            $priceOneHouse * $time;

                    }
                    $result = PayModel::insertThanhToan($aData);
                    if ($result) {
                        RoomsModel::update($aData['IDPhong'], [
                            'TrangThai' => 0
                        ]);
                        echo Message::success("The pay is successful");
                        die();
                    }
                    echo Message::error("The pay is not successful", 401);
                } else {
                    echo Message::error('The param is not empty', 401);
                }
            } else {
                echo Message::error('User not access', 401);
            }
        } catch (Exception $exception) {
            echo Message::error($exception->getMessage(), $exception->getCode());
        }
    }
}