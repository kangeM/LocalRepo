<?php

namespace backend\libraries;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use backend\models\UserAudits;
use backend\models\UserAuditDetails;
/**
* Audits
*/
class Audits 
{

  //Function to log the audit trails
	public static function logAudit($user_id,$client_id,$action_id,$comments,$table_name,$table_key,$status)
	{
		try{
			//Log it 
			$auditLog = new UserAudits();
			$auditLog->user_id=$user_id;
			$auditLog->client_id=$client_id;
			$auditLog->action_id=$action_id;
			$auditLog->comments=$comments;//comments
			$auditLog->table_name=$table_name;
			$auditLog->table_key=$table_key;
			$auditLog->status=$status;

			if($auditLog->save())
			{
				return $auditLog->id;

			}else{
			}
			

		}catch(Exception $e)
		{

		}
		return NULL;
  }
  

  	//Handle the logging of the details
	public static function logAuditDetails($oldattributes,$model,$user_audit_id	,$newattributeskip=NULL)
	{
		$newattributes=NULL;
		$newattributes = $model->getAttributes();
		

		try{

			if (!$model->isNewRecord) {
            
          
			// compare old and new
			foreach ($newattributes as $name => $value) {
				if (!empty($oldattributes)) {
					$old = $oldattributes[$name];
				} else {
					$old =NULL;
				}

				if ($value != $old) {

					//Log it 
					$auditLogDetails = new UserAuditDetails();
					$auditLogDetails->user_audit_id=$user_audit_id;
					$auditLogDetails->old_value=$old;
					$auditLogDetails->new_value= $value;
					$auditLogDetails->field=$name;

					
					$auditLogDetails->save();
					
				}else if($newattributeskip==1){
					//Log it 
					$auditLogDetails = new UserAuditDetails();
					$auditLogDetails->user_audit_id=$user_audit_id;
					$auditLogDetails->old_value=$old;
					$auditLogDetails->new_value= '';
					$auditLogDetails->field=$name;

					
					$auditLogDetails->save();
				}

      }
         

			
		} else {

			     
			foreach ($newattributes as $name => $value) {
				        //Log it 
						$auditLogDetails = new AuditTrailDetails();
						$auditLogDetails->user_audit_id=$user_audit_id;
						$auditLogDetails->old_value='';
						$auditLogDetails->new_value= $value;
						$auditLogDetails->field=$name;

				        $auditLogDetails->save();
				     }
			      
				
		}
	 }catch(Exception $e)
		{

		}
			
			

		
		return NULL;
  }
  
}

?>