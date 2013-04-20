<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Chart_Year
{
    public static $last_date_changing_data=NULL;
    public static function init_last_date_changing()
    {
        self::$last_date_changing_data = DB_DETAILS::ADD_ACTION(
                "
                    SELECT * FROM data ORDER BY  (Months+0)+(Year+0)*12 DESC LIMIT 1
                ", DB_DETAILS::$TYPE_SELECT);
        self::$last_date_changing_data = self::$last_date_changing_data[0];
    }
}
?>
