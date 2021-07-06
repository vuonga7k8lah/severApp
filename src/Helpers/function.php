<?php

use severApp\Models\RoomsModel;
use severApp\Models\ServiceModel;
use severApp\Models\UserModel;

function checkValidateData($aData)
{
    foreach ($aData as $key => $data) {
        switch ($key){
            case 'TuSua':
            case 'TrangThai':
            if ($data == 0 || $data == 1) {
                $aSuccess[$key] = true;
            }else {
                $aError[$key] = true;
            }
            break;
            case 'Option':
                if ($data == 'TheoPhong' || $data == 'TheoGio') {
                    $aSuccess[$key] = true;
                }else {
                    $aError[$key] = true;
                }
                break;
            default:
                if (!empty($data)) {
                    $aSuccess[$key] = true;
                } else {
                    $aError[$key] = true;
                }
                break;
        }
    }
    if (isset($aError)) {
        return false;
    }
    return true;
}

function checkIDUser($userName): bool
{
    if (UserModel::isUserExist($userName)) {
        return true;
    } else {
        return false;
    }
}

function checkIDPhong($IDPhong): bool
{
    if (RoomsModel::isExist($IDPhong)) {
        return true;
    } else {
        return false;
    }
}

function handlePays($idDichVu): int
{
    $gia = 0;
    $aIDDV = explode(',', $idDichVu);
    foreach ($aIDDV as $id) {
        if (ServiceModel::isExist($id)) {
            $gia += ServiceModel::getGiaWithID($id);
        }
    }
    return $gia;
}