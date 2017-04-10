<?php
/**
 * Created by PhpStorm.
 * User: yejianlin
 * Date: 2017/2/6
 * Time: 9:33
 */

namespace App\Http\Service\Tcp\Parser;


class BiteCommandParser extends CommandParser
{
    public function parseContent($response) {
        $bite_time = $this->command->getSendTime ();
        $content = array (
            "biteTime" => $bite_time
        );
        return $content;
    }
}