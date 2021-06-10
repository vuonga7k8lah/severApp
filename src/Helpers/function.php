<?php

use severApp\Models\RoomsModel;
use severApp\Models\ServiceModel;
use severApp\Models\UserModel;

function checkValidateData($aData)
{
    foreach ($aData as $key => $data) {
        if (($key === 'TuSua') || $key === 'TrangThai' ) {
            if ($data == 0 || $data == 1) {
                $aSuccess[$key] = true;
            }else {
                $aError[$key] = true;
            }
        } else {
            if (!empty($data)) {
                $aSuccess[$key] = true;
            } else {
                $aError[$key] = true;
            }
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