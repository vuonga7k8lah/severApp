<?php
function checkValidateData($aData)
{
    foreach ($aData as $key => $data) {
        if ($key === 'TuSua') {
            if ($data == 0 || $data == 1) {
                $aSuccess[$key]=true;
            }else{
                $aError[$key]=true;
            }
        } else {
            if (!empty($data)){
                $aSuccess[$key]=true;
            }else{
                $aError[$key]=true;
            }
        }
    }
   if (isset($aError)){
       return false;
   }
    return true;
}