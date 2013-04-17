<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class CHART_Chain
{
    public $id, $chain, $chain_name_gr, $chain_name_en;
    
    public function CHART_Chain( $row_data_chain )
    {    
        $this->id = $row_data_chain["id"];
        $this->chain = $row_data_chain["chain"];
        $this->chain_name_gr = $row_data_chain["chain_name_gr"];
        $this->chain_name_en = $row_data_chain["chain_name_en"];
    }
    
    /*
     * All chains reference
     */
    public static $all_chains;
    
    /*
     * When dealer i should use this reference to array of the chains
     */
    public static $all_chains_when_dealer;
    
    /*
     * Reference for chain for using
     */
    public static $chains_for_using;
    
    /*
     * Before using array of the chains they must be init
     */
    public static function init_all()
    {
        self::$all_chains = 
        DB_DETAILS::ADD_ACTION("
            SELECT * FROM chains
        ", DB_DETAILS::$TYPE_SELECT);
    }
    public static function init_for_dealer()
    {
        $dealer_data = DB_DETAILS::ADD_ACTION("
            SELECT * FROM dealers WHERE dealer_code='".CHART_User::$LOGGED_USER->dealer_code."'
        ", DB_DETAILS::$TYPE_SELECT);
        self::$all_chains_when_dealer = array();
        
        /*
         * If not dealer, array will be empthy...
         * When logged user is dealer, and this is empthy, then we have error.
         * So, pass the error please
         */
        if(count($dealer_data) == 0)
        {
            if(CHART_User::$LOGGED_USER->user_type == CHART_User::TYPE_DEALER)
            {
                print "error: Chain::init_for_dealer, error, for dealer not options.";
            }
            return;
        }
        
        for($i=0;$i<count(self::$all_chains);$i++)
        if(self::$all_chains[$i]["chain"] == $dealer_data[0]["chain"])
        {
            array_push(self::$all_chains_when_dealer, self::$all_chains[$i]);
        }
    }
}
?>
