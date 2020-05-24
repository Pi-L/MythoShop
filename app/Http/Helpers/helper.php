<?php
    // in composer.json in "autoload", added
    //  "autoload": {
    // ...,
    // "files": [
    //   "app/Http/Helpers/helper.php"
    // ]

    function telToDB(?string $phone = '') {
        $telRegex = '#(0[\d]{9})#';
        $phone = preg_replace('#^(\+33)#', '0', $phone);
        $phone = preg_filter('#[\D]*#', '', $phone);
        $dBphone = preg_match($telRegex, $phone);

        return  $dBphone ? $phone : '';
    }


    function telToView(?string $phone = '') {
        $telRegex = '#((\+33\d)|(0\d))(?:\D+)?(\d\d)(?:\D+)?(\d\d)(?:\D+)?(\d\d)(?:\D+)?(\d\d)#';
        $telPatternReplace = '$1 $4 $5 $6 $7';
        return preg_replace($telRegex, $telPatternReplace, $phone);
    }
