<?php

use Illuminate\Support\Facades\DB;

function getRoleId()
{
    return session('user')->idrole;
}
function getRole()
{
    return DB::table('role')->where('idrole', session('user')->idrole)->first()->role;
}
function splitKodeGolongan($kodegolongan)
{
    return implode('.', str_split($kodegolongan));
}

function stringPad($word, $length = 2, $pad = '0', $type = STR_PAD_LEFT)
{
    return str_pad($word, $length, $pad, $type);
}

function dataToOption($allData, $attr = false)
{
    $html = "<option value=''>Mohon Pilih</option>";
    foreach ($allData as $index => $data) {
        if ($attr) {
            $html .= "<option data-attr='".$data->attribute."' value='".(isset($data->id) ? $data->id : $data->name)."'>".$data->name.' ( Tersedia di '.$data->attribute.')</option>';
        } else {
            $html .= "<option value='".(isset($data->id) ? $data->id : $data->name)."'>".$data->name.'</option>';
        }
    }

    return $html;
}
function classificationType(array $conditions)
{
    return DB::table('masterkapitalisasi')->where('kodegolongan', $conditions['kodegolongan'])->where('kodebidang', $conditions['kodebidang'])->first();
}
function getKoderegister(array $paramRegister)
{
    $allowedColumn = [
        'kodeurusan',
        'kodesuburusan',
        'kodeorganisasi',
        'kodesuborganisasi',
        'kodeunit',
        'kodesubunit',
        'kodesubsubunit',
        'kodegolongan',
        'kodebidang',
        'kodekelompok',
        'kodesub',
        'kodesubsub',
        'tahunorganisasi',
        'tahunperolehan',
    ];

    $tmpWhere = [];

    $query = DB::table('kib')
        ->where('tahunorganisasi', 2024)
        ->where('statusdata', 'aktif');

    $akumLength = 0;
    foreach ($paramRegister as $key => $value) {
        if (in_array($key, $allowedColumn)) {
            $query->where($key, $value);
            $akumLength++;
            array_push($tmpWhere, $key);
        }
    }
    if ($akumLength < count($allowedColumn)) {
        throw new \Exception("Kolom yang diminta kurang! berikut daftarnya : \n".implode("\n", array_diff($allowedColumn, $tmpWhere)), 1);
    }

    return ($query->max('koderegister') ?? 0) + 1;
}
function convertStringToNumber($string)
{
    return implode('', explode('.', $string));
}
function getkdunit($sp2d)
{
    return DB::table('sp2d')
        ->where([
            'kdper' => $sp2d['kdper'],
            'nosp2d' => $sp2d['nosp2d'],
            'tglsp2d' => $sp2d['tglsp2d'],
        ])->first()->kdunit;
}
if (! function_exists('convertAlphabeticalToNumberDate')) {
    function convertAlphabeticalToNumberDate($stringDate)
    {
        if ($stringDate != null) {
            $number = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
            $stringDate = explode(' ', $stringDate);
            switch ($stringDate[1]) {
                case 'Januari':
                    $str = $stringDate[2].'-'.$number[0].'-'.$stringDate[0];
                    break;
                case 'Februari':
                    $str = $stringDate[2].'-'.$number[1].'-'.$stringDate[0];
                    break;
                case 'Maret':
                    $str = $stringDate[2].'-'.$number[2].'-'.$stringDate[0];
                    break;
                case 'April':
                    $str = $stringDate[2].'-'.$number[3].'-'.$stringDate[0];
                    break;
                case 'Mei':
                    $str = $stringDate[2].'-'.$number[4].'-'.$stringDate[0];
                    break;
                case 'Juni':
                    $str = $stringDate[2].'-'.$number[5].'-'.$stringDate[0];
                    break;
                case 'Juli':
                    $str = $stringDate[2].'-'.$number[6].'-'.$stringDate[0];
                    break;
                case 'Agustus':
                    $str = $stringDate[2].'-'.$number[7].'-'.$stringDate[0];
                    break;
                case 'September':
                    $str = $stringDate[2].'-'.$number[8].'-'.$stringDate[0];
                    break;
                case 'Oktober':
                    $str = $stringDate[2].'-'.$number[9].'-'.$stringDate[0];
                    break;
                case 'November':
                    $str = $stringDate[2].'-'.$number[10].'-'.$stringDate[0];
                    break;
                case 'Desember':
                    $str = $stringDate[2].'-'.$number[11].'-'.$stringDate[0];
                    break;
                default:
                    $str = $stringDate[2].'- not valid -'.$stringDate[0];
                    break;
            }

            return $str;
        } else {
            return $stringDate;
        }
    }
}
if (! function_exists('convertNumericDateToAlphabetical')) {
    function convertNumericDateToAlphabetical($stringDate)
    {
        if ($stringDate != null) {
            $number = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $stringDate = explode('-', $stringDate);
            switch ($stringDate[1]) {
                case '01':
                    $str = $stringDate[2].' '.$number[0].' '.$stringDate[0];
                    break;
                case '02':
                    $str = $stringDate[2].' '.$number[1].' '.$stringDate[0];
                    break;
                case '03':
                    $str = $stringDate[2].' '.$number[2].' '.$stringDate[0];
                    break;
                case '04':
                    $str = $stringDate[2].' '.$number[3].' '.$stringDate[0];
                    break;
                case '05':
                    $str = $stringDate[2].' '.$number[4].' '.$stringDate[0];
                    break;
                case '06':
                    $str = $stringDate[2].' '.$number[5].' '.$stringDate[0];
                    break;
                case '07':
                    $str = $stringDate[2].' '.$number[6].' '.$stringDate[0];
                    break;
                case '08':
                    $str = $stringDate[2].' '.$number[7].' '.$stringDate[0];
                    break;
                case '09':
                    $str = $stringDate[2].' '.$number[8].' '.$stringDate[0];
                    break;
                case '10':
                    $str = $stringDate[2].' '.$number[9].' '.$stringDate[0];
                    break;
                case '11':
                    $str = $stringDate[2].' '.$number[10].' '.$stringDate[0];
                    break;
                case '12':
                    $str = $stringDate[2].' '.$number[11].' '.$stringDate[0];
                    break;
                default:
                    $str = $stringDate[2].'  not valid  '.$stringDate[0];
                    break;
            }

            return $str;
        } else {
            return $stringDate;
        }
    }
}
function kodeOrganisasi()
{
    $copi = clone session('organisasi');
    unset($copi->organisasi, $copi->tahunorganisasi, $copi->wajibsusut);

    return implode('.', array_values((array) $copi));
}

function getOrganisasi()
{
    return session('organisasi')->organisasi;
}
function buildTree(array &$elements, $idParent = 0)
{
    $branch = [];
    foreach ($elements as $element) {
        $element = (array) $element;
        if ($element['parent'] == $idParent) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            unset($element['parent']);
            $branch[] = $element;
        }
    }

    return $branch;
}
function buildTreeMenu(array &$elements, $idParent = '0')
{
    $branch = [];
    foreach ($elements as $element) {
        $element = (array) $element;
        if ($element['parent'] === $idParent) {
            // dd($elements, $element['parent'], $element['id']);
            $children = buildTreeMenu($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            unset($element['parent']);
            $branch[] = $element;
        }
    }

    return $branch;
}
function buildTreeOrganisasi(array &$elements, $idParent = '0')
{
    $branch = [];
    foreach ($elements as $element) {
        $element = (array) $element;
        if ($element['parent'] === $idParent) {
            // dd($elements, $element['parent'], $element['id']);
            $children = buildTreeOrganisasi($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            unset($element['parent']);
            $branch[] = $element;
        }
    }

    return $branch;
}

function buildMenu(array &$elements, $place = 'sidebar')
{
    $html = '';
    foreach ($elements as $element) {
        $element = (array) $element;
        if ($place == 'sidebar') {
            if (isset($element['children'])) {
                $children = buildMenu($element['children']);
                $html .= '<li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons '.$element['icons'].'"></i>
                            <div data-i18n="Layouts">'.$element['nama'].'</div>
                        </a>

                        <ul class="menu-sub">'.$children.'</ul>
                    </li>';
            } else {
                $html .= '<li class="menu-item '.(app('request')->route()->named($element['link']) ? 'active' : '').'">
                    <a href="'.route($element['link']).'" class="menu-link ">
                        <i class="menu-icon tf-icons '.$element['icons'].'"></i>
                        <div data-i18n="Analytics">'.$element['nama'].'</div>
                    </a>
                </li>';
            }
        } elseif ($place == 'profile') {
            $html .= '<li>
                        <a class="dropdown-item" href="'.route($element['link']).'">
                            <span class="d-flex align-items-center align-middle">
                                <i class="flex-shrink-0 me-2 '.$element['icons'].'"></i>
                                <span class="flex-grow-1 align-middle">'.$element['nama'].'</span>
                            </span>
                        </a>
                    </li>';
            // '<span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>'
        }
    }

    return $html;
}
function limitOffsetToArray($limit = 5, $offset = 1)
{
    $data = [];
    for ($i = ($limit + $offset) - $limit; $i < ($limit + $offset); $i++) {
        array_push($data, $i);
    }

    return $data;
}
