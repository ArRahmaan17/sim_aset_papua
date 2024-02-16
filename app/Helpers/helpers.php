<?php

function splitKodeGolongan($kodegolongan)
{
    return implode('.', str_split($kodegolongan));
}

function stringPad($word, $length = 2, $pad = "0", $type = STR_PAD_LEFT)
{
    return str_pad($word, $length, $pad, $type);
}

function dataToOption($allData, $attr = false)
{
    $html = "<option value=''>Mohon Pilih</option>";
    foreach ($allData as $index => $data) {
        if ($attr) {
            $html .= "<option data-attr='" . $data->attribute . "' value='" . (isset($data->id) ? $data->id : $data->name) . "'>" . $data->name . " ( Tersedia di " . $data->attribute . ")</option>";
        } else {
            $html .= "<option value='" . (isset($data->id) ? $data->id : $data->name) . "'>" . $data->name . "</option>";
        }
    }
    return $html;
}
