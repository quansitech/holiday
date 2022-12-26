<?php

class GenCalendarFile
{

    static protected string $base_url = 'http://api.haoshenqi.top/holiday';
    static protected string $year;
    static protected string $error = '';
    static protected string $url = '';

    static protected function setUrl():void{
        $query = http_build_query(['date' => self::$year]);
        self::$url = self::$base_url.'?'.$query;
    }

    static protected function setYear(string $year = ''):void{
        if (empty($year)){
            $year = date("Y", strtotime('+1 Year'));
        }
        self::$year = $year;
    }

    static protected function setError(string $error){
        self::$error = $error;
    }

    static public function getError():string{
        return self::$error;
    }

    static public function gen(string $year = ''):bool{
        try {
            self::setYear($year);

            $json = self::fetchJson();
            if ($json === false){
                throw new \Exception("获取数据失败，请检查链接是否有效 ". self::$url);
            }

            $write_r = self::writeToFile($json);
            if ($write_r === false){
                throw new \Exception("写入文件出错");
            }

            return true;
        }catch (\Exception $e){
            self::setError("生成含假期的日历文件失败：".$e->getMessage());
            return false;
        }
    }

    static protected function fetchJson():string|false{
        self::setUrl();

        return file_get_contents(self::$url);
    }

    static protected function genFileName():string{
        $dir = __DIR__.'/Calendar/';
        return $dir.self::$year."_calendar.json";
    }

    static protected function genContent(string $calendar_text):string{
        return $calendar_text;
    }

    static protected function writeToFile($json):int|false{
        $file_name = self::genFileName();

        return file_put_contents($file_name, self::genContent($json));
    }

    static public function getCalendar(string $year){
        if (!self::checkYear($year)){
            return '[]';
        }

        self::setYear($year);

        $file_name = self::genFileName();
        if (!file_exists($file_name)){
            $r = self::gen($year);
            if ($r === false){
                fwrite(STDOUT, self::getError());
                return '[]';
            }
        }

        return file_get_contents($file_name);
    }

    static protected function checkYear(string $year):bool{
        if (empty($year)){
            return false;
        }

        if (!preg_match('/^\d{4}$/', $year)){
            return false;
        }

        if ($year > date("Y", strtotime('+1 Year')) || $year <= '2010'){
            return false;
        }

        return true;
    }
}