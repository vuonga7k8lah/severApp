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
            $aData = $aDataPay;
            $aData['infoKhach'] = json_decode($aDataPay['infoKhach'], true);
            if ($aDataPay) {
                echo Message::success('list data', $aData);
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
            if (isset($aData['qrcode']) && !empty($aData['qrcode'])) {
                $aUserData = $this->decodeJWT($aData['token']);
                $aData['IDUser'] = $aUserData->ID;
                $aInfo = json_decode($this->decodeJWT($aData['qrcode']), true);
                unset($aData['token']);
                unset($aData['qrcode']);
                $aInfoKhach = [
                    'Ten'    => $aInfo['hoTen'],
                    'CMT'    => '',
                    'SDT'    => $aInfo['sdt'],
                    'DiaChi' => ''
                ];
                $aData['infoKhach'] = json_encode($aInfoKhach);
                $aData['IDPhong'] = rand(0, RoomsModel::getAllIDs());
                $aData['ThanhToan'] = $aInfo['gia'];
                $aData['Option'] = 'TheoPhong';
                $aData['DichVu'] = 1;
                $ID = PayModel::insert($aData);
                if ($ID) {
                    RoomsModel::update($aData['IDPhong'], [
                        'TrangThai' => 1
                    ]);
                    echo Message::success('The pay create successfully', [
                        'ID'      => $ID,
                        'IDPhong' => $aData['IDPhong'],
                    ]);
                    die();
                }
                echo Message::error('The pay create not successfully', 401);
            } else {
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
                    die();
                }
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
                    $IDPhong = PayModel::getFields($aData['ID'], 'IDPhong');
                    $aUserData = $this->decodeJWT($aData['token']);
                    $aData['IDUser'] = $aUserData->ID;
                    if (!isset($aData['ThanhToan'])) {
                        $aData['ThanhToan'] = (int)handlePays($aData['DichVu']) + (int)(RoomsModel::getRoom
                            ($IDPhong)['Gia']);
                    }
                    $status = PayModel::update($aData['ID'], $aData);
                    if ($status) {
                        echo Message::success('The pay update successfully', []);
                        die();
                    }
                    echo Message::error('The pay update not successfully', 401);
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
                    throw new Exception("ID H??a ????n Ch??a T???n T???i", 401);
                }
                if (checkValidateData($aData)) {
                    $option = PayModel::getFields($aData['ID'], 'Option');
                    $aData['IDPhong'] = PayModel::getFields($aData['ID'], 'IDPhong');
                    $aData['IDHoaDon'] = $aData['ID'];
                    if ($option === 'TheoPhong') {
                        $aData['TongTien'] = (int)PayModel::getFields($aData['ID'], 'ThanhToan');
                    } else {
                        //set th???i gian v??? m??i gi???i HCM
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        //set Gi?? c???a 1 gi??? b???ng ti???n ph??ng 110% gi?? ph??ng
                        $priceOneHouse = (int)(RoomsModel::getRoom($aData['IDPhong'])['Gia']) * 1.1;
                        //t??nh Gi??? Thanh ???? ??? b???ng th???i gian hi???n t???i tr??? ??i th???i gian t???o h??a ????n
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
