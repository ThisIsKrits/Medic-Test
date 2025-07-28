<?php
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Enums\AktifEnum;
use App\Enums\StatusPeriodEnum;

if (!function_exists('random_string')) {
    function random_string($val = 10)
    {
        return Str::random($val);
    }
}

if (!function_exists('checklist')) {
    function checklist()
    {
        return '<i class="fa-solid fa-check"></i>';
    }
}

if (!function_exists('faminus')) {
    function faminus()
    {
        return '<i class="fa-solid fa-minus"></i>';
    }
}

if (!function_exists('human_date')) {
    function human_date($date, $format = false, $addHour = false)
    {
        Carbon::setLocale('id');

        $carbon = Carbon::parse($date);
        if($addHour) {
            $carbon = $carbon->addHour($addHour);
        }


        if($format) {
            return $carbon->isoFormat($format);
        }
        return $carbon->isoFormat('D MMMM Y');
    }
}

if (!function_exists('human_date_slash')) {
    function human_date_slash($date, $format = false, $addHour = false)
    {
        Carbon::setLocale('id');

        $carbon = Carbon::parse($date);
        if($addHour) {
            $carbon = $carbon->addHour($addHour);
        }


        if($format) {
            return $carbon->isoFormat($format);
        }
        return $carbon->isoFormat('D/MM/Y');
    }
}

if (!function_exists('human_periode')) {
    function human_periode($dateRange, $format = false, $onlyLast = false)
    {
        $tgl  = explode(' - ', $dateRange);
        $fixFormatSt = '01 MMMM Y';
        $fixFormatNd = total_days($tgl[1]).' MMMM Y';
        $sparasi = str_contains($format, ' ') ? ' ' : '-';

        if($format) {
            $fixFormatSt = '01'.$sparasi.$format;
            $fixFormatNd = total_days($tgl[1]).$sparasi.$format;
        }


        $tgl[0] = human_date($tgl[0], $fixFormatSt);
        $tgl[1] = human_date($tgl[1], $fixFormatNd);

        if($onlyLast) {
            return $tgl[1];
        }

        return $tgl[0] . ' s/d ' . $tgl[1];
    }
}

if (!function_exists('human_number')) {
    function human_number($number)
    {
        if($number != "") {
            return number_format($number, 2, ',', '.');
        }
    }
}

if (!function_exists('is_editpage')) {
    function is_editpage()
    {
        if(in_array('edit', explode(".", request()->route()->getName()))) {
            return true;
        }
        return false;

    }
}

if (!function_exists('number_to_alphabet')) {
    function number_to_alphabet($number) {
        $number = intval($number);
        if ($number <= 0) {
            return '';
        }
        $alphabet = '';
        while($number != 0) {
            $p = ($number - 1) % 26;
            $number = intval(($number - $p) / 26);
            $alphabet = chr(65 + $p) . $alphabet;
        }
        return $alphabet;
    }
}

if (!function_exists('alphabet_to_number')) {
    function alphabet_to_number($string) {
        $string = strtoupper($string);
        $length = strlen($string);
        $number = 0;
        $level = 1;
        while ($length >= $level ) {
            $char = $string[$length - $level];
            $c = ord($char) - 64;
            $number += $c * (26 ** ($level-1));
            $level++;
        }

        return $number;
    }
}

if (!function_exists('terbilang')) {
    function terbilang($nilai)
    {
        $poin = tkoma($nilai);
        $hasil = trim(penyebut($nilai))." ".$poin;

        if ($nilai < 0) {
            return trim("minus ". $hasil);
		}

		return trim($hasil);
    }
}

if (!function_exists('penyebut')) {
    function penyebut($nilai)
    {
        $nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}
		return $temp;
    }
}

if (!function_exists('tkoma')) {
    function tkoma($nilai) {
        $split = explode(".", $nilai);
        if(count($split) < 2) {
            return '';
        }

        $str = $split[1];
        if(substr($str, 0, 1) != '0') {
            $temp = terbilang($str);
            return "koma ".trim($temp);
        }

        $string = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan");
        $temp = "";
        $pjg = strlen($str);
        $i = 0;

        while ($i < $pjg){
            $char = substr($str,$i,1);
            $i++;
            $temp .= " ".$string[$char];
        }

        return "koma ".trim($temp);
    }
}

if (!function_exists('month_diff')) {
    function month_diff($firstDate, $secondDate)
    {
        $firstDate = Carbon::parse($firstDate)->isoFormat('Y-MM');
        $secondDate = Carbon::parse($secondDate)->isoFormat('Y-MM');

        $date1 = date_create($firstDate);
        $date2 = date_create($secondDate);
        $diff = date_diff($date1, $date2);

        return (int) $diff->format('%m');
    }
}

if (!function_exists('date_add_sub')) {
    function date_add_sub($date, $days, $operation = 'plus')
    {
        $tgl = Carbon::parse($date);
        if($operation == 'plus') {
            return $tgl->addDays($days)->isoFormat('Y-MM-DD');
        }
        return $tgl->subDays($days)->isoFormat('Y-MM-DD');


        // $firstDate = Carbon::parse($firstDate)->isoFormat('Y-MM-DD');
        // $secondDate = Carbon::parse($secondDate)->isoFormat('Y-MM-DD');

        // $date1 = date_create($firstDate);
        // $date2 = date_create($secondDate);
        // $diff = date_diff($date1, $date2);

        // return (int) $diff->format('%r%a');
    }
}

if (!function_exists('day_diff')) {
    function day_diff($firstDate, $secondDate)
    {
        $firstDate = Carbon::parse($firstDate)->isoFormat('Y-MM-DD');
        $secondDate = Carbon::parse($secondDate)->isoFormat('Y-MM-DD');

        $date1 = date_create($firstDate);
        $date2 = date_create($secondDate);
        $diff = date_diff($date1, $date2);

        return (int) $diff->format('%r%a');
    }
}

if (!function_exists('total_days')) {
    function total_days($date)
    {
        return Carbon::parse($date)->daysInMonth;
    }
}

if (!function_exists('jum_operation')) {
    function jum_operation($curentNumber, $updateNumber)
    {
        if($curentNumber > $updateNumber) {
            return [
                'jum' => ($curentNumber - $updateNumber),
                'operation' => 'minus'
            ];
        }

        return [
            'jum' => ($updateNumber - $curentNumber),
            'operation' => 'plus'
        ];
    }
}

if (!function_exists('parsing_option_select')) {
    function parsing_option_select($items, $id = false, $defaultLabel = 'Pilih', $withoutPilih = false)
    {
        $html = $withoutPilih ? '' : default_option_select($defaultLabel);

        foreach($items as $key => $value) {
            $sel = ($id && $id == $key) ? "selected" : "";
            $html .= '<option value="'.$key.'" '.$sel.'>'.$value.'</option>';
        }
        return $html;
    }
}

if (!function_exists('parsing_option_select_collection')) {
    function parsing_option_select_collection($items, $keyLabel, $id = false, $attribute = false)
    {
        $html = default_option_select();

        $attr = '';

        foreach($items as $item) {

            $sel = ($id && $id == $item->{$keyLabel['key']}) ? "selected" : "";
            if($attribute) {
                foreach ($attribute as $attrKey => $itmKey) {
                    $attr .=' '.$attrKey.'="'.$item->{$itmKey}.'"';
                }
            }
            $html .= '<option
                        value="'.$item->{$keyLabel['key']}.'"
                        '.$attr.'
                        '.$sel.'>
                        '.$item->{$keyLabel['label']}.'</option>';
        }
        return $html;
    }
}


if (!function_exists('default_option_select')) {
    function default_option_select($label = 'Pilih', $value = "")
    {
        return '<option value="'.$value.'">'.$label.'</option>';
    }
}

if (!function_exists('default_status_checkbox')) {
    function default_status_checkbox($status, $id, $routeName = false)
    {
        $cheked = $status == AktifEnum::AKTIF
            ? "checked"
            : "";

        $checkbox = '<div class="form-check form-switch d-inline-block">
            <input class="form-check-input activated-status" type="checkbox" id="'.$id.'"
            '.$cheked.'>
        </div>';

        if($routeName) {
            $checkbox .= '<form id="set-aktif-'.$id.'" action="'.route($routeName, [$id, "ref" => 'activate']).'" method="POST" class="d-none">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="'.csrf_token().'">
            </form>';
        }

        return $checkbox;
    }
}

if (!function_exists('default_open_checkbox')) {
    function default_open_checkbox($status, $id, $routeName = false)
    {
        $cheked = $status == StatusPeriodEnum::OPEN
            ? "checked"
            : "";

        $checkbox = '<div class="form-check form-switch d-inline-block">
            <input class="form-check-input activated-status" type="checkbox" id="'.$id.'"
            '.$cheked.'>
        </div>';

        if($routeName) {
            $checkbox .= '<form id="set-aktif-'.$id.'" action="'.route($routeName, [$id, "ref" => 'activate']).'" method="POST" class="d-none">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="'.csrf_token().'">
            </form>';
        }

        return $checkbox;
    }
}

if (!function_exists('create_dir')) {
    function create_dir($path, $permission = 0755)
    {
        if (!file_exists($path)) {
            mkdir($path, $permission, true);
        }
    }
}

if (!function_exists('save_image')) {
    function save_image($file, $path, $filename)
    {
        // Simpan gambar langsung tanpa resize
        $file->move($path, $filename);

        return $filename;
    }
}


if (!function_exists('save_pdf')) {
    function save_pdf($file, $path, $filename)
    {
        $file->move($path, $filename);
        return basename($path.'/'.$filename);
    }
}
