<?php
/*
Plugin Name: Zero BS CRM Extension: Advanced Segments (temp)
Plugin URI: https://zerobscrm.com
Description: Pimped segments (this'll be in MC2 eventually)
Version: 1.0
Author: Zero BS CRM.com
http://zerobscrm.com
*/

/*
 * This adds each additional condition to the system
*/
function zeroBSCRM_advSegmentConditions(){

    $arg = new zbsSegmentCondition_QuoteCount();
    $arg = new zbsSegmentCondition_InvCount();
    $arg = new zbsSegmentCondition_TranCount();
    $arg = new zbsSegmentCondition_Country();
    $arg = new zbsSegmentCondition_County();
    $arg = new zbsSegmentCondition_Postal();

} add_action('admin_init','zeroBSCRM_advSegmentConditions',1);



/* ====================================================================================
 * The following classes each represent a possible segment condition
 * // CONDITIONS
 * ==================================================================================== */
class zbsSegmentCondition_QuoteCount extends zeroBSCRM_segmentCondition {

    public $key = 'quotecount';
    public $condition = array('name'=>'Quote Count','operators' => array('equal','notequal','larger','less','intrange'),'fieldname'=>'quotecount');
    public function conditionArg($startingArg=false,$condition=false,$conditionKeySuffix=false){
                
        global $zbs,$wpdb,$ZBSCRM_t;

                //  'equal','notequal','larger','less','intrange'

                /*  
                $query = "SELECT COUNT(posts.ID) FROM $wpdb->posts posts LEFT JOIN $wpdb->postmeta postmeta ON posts.ID = postmeta.post_id
                WHERE posts.post_type IN ('zerobs_quote','zerobs_invoice','zerobs_transaction') AND posts.post_status = 'publish'
                AND postmeta.meta_value = contact.ID AND postmeta.meta_key IN ('zbs_customer_quote_customer','zbs_customer_invoice_customer','zbs_parent_cust')";
                */

                $quoteCountQuery = "SELECT COUNT(posts.ID) FROM $wpdb->posts posts LEFT JOIN $wpdb->postmeta postmeta ON posts.ID = postmeta.post_id WHERE posts.post_type ='zerobs_quote' AND posts.post_status = 'publish' AND postmeta.meta_value = contact.ID AND postmeta.meta_key = 'zbs_customer_quote_customer'";

                if ($condition['operator'] == 'equal')
                    return array('additionalWhereArr'=>
                                array('quoteCEqual'.$conditionKeySuffix=>array("(".$quoteCountQuery.")",'=','%d',$condition['value']))
                            );
                else if ($condition['operator'] == 'notequal')
                    return array('additionalWhereArr'=>
                                array('quoteCNotEqual'.$conditionKeySuffix=>array("(".$quoteCountQuery.")",'<>','%d',$condition['value']))
                            );
                else if ($condition['operator'] == 'larger')
                    return array('additionalWhereArr'=>
                                array('quoteCLarger'.$conditionKeySuffix=>array("(".$quoteCountQuery.")",'>','%d',$condition['value']))
                            );
                else if ($condition['operator'] == 'less')
                    return array('additionalWhereArr'=>
                                array('quoteCLess'.$conditionKeySuffix=>array("(".$quoteCountQuery.")",'<','%d',$condition['value']))
                            );
                else if ($condition['operator'] == 'intrange')
                    return array('additionalWhereArr'=>
                                array(
                                    'quoteCLarger'.$conditionKeySuffix=>array("(".$quoteCountQuery.")",'>=','%d',$condition['value']),
                                    'quoteCLess'.$conditionKeySuffix=>array("(".$quoteCountQuery.")",'<=','%d',$condition['value2'])
                                )
                            );

        return $startingArg;
    }
}
class zbsSegmentCondition_InvCount extends zeroBSCRM_segmentCondition {

    public $key = 'invcount';
    public $condition = array('name'=>'Invoice Count','operators' => array('equal','notequal','larger','less','intrange'),'fieldname'=>'invcount');
    public function conditionArg($startingArg=false,$condition=false,$conditionKeySuffix=false){

        global $zbs,$wpdb,$ZBSCRM_t;
        
            $invCountQuery = "SELECT COUNT(posts.ID) FROM $wpdb->posts posts LEFT JOIN $wpdb->postmeta postmeta ON posts.ID = postmeta.post_id WHERE posts.post_type ='zerobs_invoice' AND posts.post_status = 'publish' AND postmeta.meta_value = contact.ID AND postmeta.meta_key = 'zbs_customer_invoice_customer'";

            if ($condition['operator'] == 'equal')
                return array('additionalWhereArr'=>
                            array('invCEqual'.$conditionKeySuffix=>array("(".$invCountQuery.")",'=','%d',$condition['value']))
                        );
            else if ($condition['operator'] == 'notequal')
                return array('additionalWhereArr'=>
                            array('invCNotEqual'.$conditionKeySuffix=>array("(".$invCountQuery.")",'<>','%d',$condition['value']))
                        );
            else if ($condition['operator'] == 'larger')
                return array('additionalWhereArr'=>
                            array('invCLarger'.$conditionKeySuffix=>array("(".$invCountQuery.")",'>','%d',$condition['value']))
                        );
            else if ($condition['operator'] == 'less')
                return array('additionalWhereArr'=>
                            array('invCLess'.$conditionKeySuffix=>array("(".$invCountQuery.")",'<','%d',$condition['value']))
                        );
            else if ($condition['operator'] == 'intrange')
                return array('additionalWhereArr'=>
                            array(
                                'invCLarger'.$conditionKeySuffix=>array("(".$invCountQuery.")",'>=','%d',$condition['value']),
                                'invCLess'.$conditionKeySuffix=>array("(".$invCountQuery.")",'<=','%d',$condition['value2'])
                            )
                        );

        return $startingArg;
    }
}
class zbsSegmentCondition_TranCount extends zeroBSCRM_segmentCondition {

    public $key = 'trancount';
    public $condition = array('name'=>'Transaction Count','operators' => array('equal','notequal','larger','less','intrange'),'fieldname'=>'trancount');
    public function conditionArg($startingArg=false,$condition=false,$conditionKeySuffix=false){
                
        global $zbs,$wpdb,$ZBSCRM_t;
        
            $tranCountQuery = "SELECT COUNT(posts.ID) FROM $wpdb->posts posts LEFT JOIN $wpdb->postmeta postmeta ON posts.ID = postmeta.post_id WHERE posts.post_type ='zerobs_transaction' AND posts.post_status = 'publish' AND postmeta.meta_value = contact.ID AND postmeta.meta_key = 'zbs_parent_cust'";

            if ($condition['operator'] == 'equal')
                return array('additionalWhereArr'=>
                            array('transCEqual'.$conditionKeySuffix=>array("(".$tranCountQuery.")",'=','%d',$condition['value']))
                        );
            else if ($condition['operator'] == 'notequal')
                return array('additionalWhereArr'=>
                            array('transCNotEqual'.$conditionKeySuffix=>array("(".$tranCountQuery.")",'<>','%d',$condition['value']))
                        );
            else if ($condition['operator'] == 'larger')
                return array('additionalWhereArr'=>
                            array('transCLarger'.$conditionKeySuffix=>array("(".$tranCountQuery.")",'>','%d',$condition['value']))
                        );
            else if ($condition['operator'] == 'less')
                return array('additionalWhereArr'=>
                            array('transCLess'.$conditionKeySuffix=>array("(".$tranCountQuery.")",'<','%d',$condition['value']))
                        );
            else if ($condition['operator'] == 'intrange')
                return array('additionalWhereArr'=>
                            array(
                                'transCLarger'.$conditionKeySuffix=>array("(".$tranCountQuery.")",'>=','%d',$condition['value']),
                                'transCLess'.$conditionKeySuffix=>array("(".$tranCountQuery.")",'<=','%d',$condition['value2'])
                            )
                        );

        return $startingArg;
    }
}
class zbsSegmentCondition_Country extends zeroBSCRM_segmentCondition {

    public $key = 'country';
    public $condition = array('name'=>'Country','operators' => array('equal','notequal'),'fieldname'=>'country');
    public function conditionArg($startingArg=false,$condition=false,$conditionKeySuffix=false){

        global $zbs,$wpdb,$ZBSCRM_t;
        
        if ($condition['operator'] == 'equal')
            // while this is right, it doesn't allow for MULTIPLE status cond lines, so do via sql:
            // return array('inCountry'=>$condition['value']);
            return $zbs->DAL->segmentBuildDirectOrClause(array(
                            'inCountry'.$conditionKeySuffix=>array('zbsc_country','=','%s',$condition['value']),
                            'inCountryAddr2'.$conditionKeySuffix=>array('zbsc_seccountry','=','%s',$condition['value']),
                    ),'OR');
        else if ($condition['operator'] == 'notequal')
            // while this is right, it doesn't allow for MULTIPLE status cond lines, so do via sql:
            // return array('notInCountry'=>$condition['value']);
            return array('additionalWhereArr'=>
                        array(
                            'notInCountry'.$conditionKeySuffix=>array('zbsc_country','<>','%s',$condition['value']),
                            'notInCountryAddr2'.$conditionKeySuffix=>array('zbsc_seccountry','<>','%s',$condition['value']),
                        )
                    );

        return $startingArg;
    }
}
class zbsSegmentCondition_County extends zeroBSCRM_segmentCondition {

    public $key = 'county';
    public $condition = array('name'=>'County','operators' => array('equal','notequal'),'fieldname'=>'county');
    public function conditionArg($startingArg=false,$condition=false,$conditionKeySuffix=false){

        global $zbs,$wpdb,$ZBSCRM_t;
        
        if ($condition['operator'] == 'equal')
            // while this is right, it doesn't allow for MULTIPLE status cond lines, so do via sql:
            // return array('inCounty'=>$condition['value']);
            return $zbs->DAL->segmentBuildDirectOrClause(array(
                            'inCounty'.$conditionKeySuffix=>array('zbsc_county','=','%s',$condition['value']),
                            'inCountyAddr2'.$conditionKeySuffix=>array('zbsc_seccounty','=','%s',$condition['value']),
                   ),'OR');
        else if ($condition['operator'] == 'notequal')
            // while this is right, it doesn't allow for MULTIPLE status cond lines, so do via sql:
            // return array('notInCounty'=>$condition['value']);
            return array('additionalWhereArr'=>
                        array(
                            'notInCounty'.$conditionKeySuffix=>array('zbsc_county','<>','%s',$condition['value']),
                            'notInCountyAddr2'.$conditionKeySuffix=>array('zbsc_seccounty','<>','%s',$condition['value']),
                        )
                    );

        return $startingArg;
    }
}
class zbsSegmentCondition_Postal extends zeroBSCRM_segmentCondition {

    public $key = 'postal';
    public $condition = array('name'=>'Postal Code','operators' => array('equal','notequal'),'fieldname'=>'postal');
    public function conditionArg($startingArg=false,$condition=false,$conditionKeySuffix=false){

        global $zbs,$wpdb,$ZBSCRM_t;
        
        if ($condition['operator'] == 'equal')
            // while this is right, it doesn't allow for MULTIPLE status cond lines, so do via sql:
            // return array('inPostCode'=>$condition['value']);
            return $zbs->DAL->segmentBuildDirectOrClause(array(
                            'inPostCode'.$conditionKeySuffix=>array('zbsc_postcode','=','%s',$condition['value']),
                            'inPostCodeAddr2'.$conditionKeySuffix=>array('zbsc_secpostcode','=','%s',$condition['value']),
                   ),'OR');
        else if ($condition['operator'] == 'notequal')
            // while this is right, it doesn't allow for MULTIPLE status cond lines, so do via sql:
            // return array('notInPostCode'=>$condition['value']);
            return array('additionalWhereArr'=>
                        array(
                            'notInPostCode'.$conditionKeySuffix=>array('zbsc_postcode','<>','%s',$condition['value']),
                            'notInPostCodeAddr2'.$conditionKeySuffix=>array('zbsc_secpostcode','<>','%s',$condition['value']),
                        )
                    );

        return $startingArg;
    }
}

/* ====================================================================================
 * / CONDITIONS
 * ==================================================================================== */