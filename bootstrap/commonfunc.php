<?php
/*
 * Make array by eloquent model
 *
 * */
function g_makeArrayIDKey($data, $idField='id')
{
    $result = array();

    foreach ($data as $record) {
        if (!isset($record->$idField)) {
            continue;
        }
        $result[$record->$idField] = $record;
    }

    return $result;
}

/*
 * Make array by array
 *
 * */
function g_makeArrayIDKeyFromArray($data, $idField='id')
{
    $result = array();

    foreach ($data as $record) {
        if (!isset($record[$idField])) {
            continue;
        }
        $result[$record[$idField]] = $record;
    }

    return $result;
}

function g_makeGroupArrayIDKey($data, $idField='id', $secondField = '')
{
    $result = array();

    foreach ($data as $record) {
        if (!isset($record[$idField])) {
            continue;
        }
        if (!empty($secondField)) {
            $result[$record[$idField]][$record[$secondField]] = $record;
        } else {
            $result[$record[$idField]][] = $record;
        }
    }

    return $result;
}

function g_enum($enumID, $value = null)
{
    global $g_masterData;

    $enumArray = array();
    if (isset($g_masterData[$enumID]))
        $enumArray = $g_masterData[$enumID];

    if (!is_array($enumArray))
        $enumArray = array();

    // get result
    $result = array();
    if (null !== $value) {
        if (strpos($value, ',') !== false) {
            $values = explode(',', $value);
        } else {
            $values = array($value);
        }
        foreach ($values as $value) {
            if (isset($enumArray[$value])) {
                $result[] = $enumArray[$value];
            }
        }
        $result = implode(', ', $result);
        return $result;
    }

    return $enumArray;
}

/**
 * Get specified element from object safely
 *
 * @param array $arr
 * @param string $key1
 * @param string $key2
 * @param mixed $default
 * @return mixed
 */
function g_getArrayValue($arr, $key1, $key2 = '', $default = '')
{
    if (empty($key2)) {
        return (isset($arr[$key1]) ? $arr[$key1] : $default);
    }

    return (isset($arr[$key1][$key2]) ? $arr[$key1][$key2] : $default);
}

/**
 * Get specified element from object safely
 * (参照：g_getArrayValue とほぼ同じ)
 *
 * @param array $array
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function g_getValue($array, $key, $default)
{
    $key = (string) $key;
    if (isset($array[$key])) {
        return $array[$key];
    }
    return $default;
}

/**
 * Format number from text
 * 32432.232 => "32,432.23"
 * 0 => "0.00"
 * @param number $val
 * @param number $precision=2
 * @return string
 * @author KIS
 */
function g_numberFormat($val, $precision=0)
{
    return number_format($val, $precision, '.', ' ');
}

function g_extractField($arr, $key) {
    $ret = [];
    foreach($arr as $record) {
        if(isset($record[$key])) {
            $ret[] = $record[$key];
        }
    }
    return $ret;
}

function cAsset($path)
{
    if (env('APP_ENV') === 'production') {
        return secure_url(ltrim($path, '/'));
    }

    return url(ltrim($path, '/'));
}

function cUrl($path) {
    if (env('APP_ENV') === 'production') {
        return secure_url($path);
    }

    return url($path);
}
