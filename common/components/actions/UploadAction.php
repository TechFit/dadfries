<?php

namespace common\components\actions;


class UploadAction extends \trntv\filekit\actions\UploadAction
{

    public function run()
    {
        $result = parent::run();

        if($this->multiple) {
            foreach ($result as $i => $file) {
                foreach ($file as $j => $item) {
                    if(isset($item['error']) && $item['error'] === true && is_array($item['errors'])) {
                        $result[$i][$j]['errors'] = $this->errors2string($item['errors']);
                    }
                }
            }
        } else {
            if(isset($result['error']) && $result['error'] === true && is_array($result['errors'])) {
                $result['errors'] = $this->errors2string($result['errors']);
            }
        }

        return $result;
    }

    protected function errors2string($errors)
    {
        $string = [];

        foreach ($errors as $attr => $errs) {
            if(is_array($errs)) {
                $string = array_merge($string, $errs);
            } elseif(is_string($errs)) {
                $string[] = $errs;
            }
        }


        return implode("\n", $string);
    }
}