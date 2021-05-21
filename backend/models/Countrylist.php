<?php


 namespace backend\models;
 use yii\rest\ActiveController;
 use Yii;
 
 class Countrylist extends ActiveRecord 
 {
	 public static function tableName()
	 {
		return 'countrylist';
	 }
	 
	 public fuction rules()
	 {
		return [
				[['iso', 'name', 'nicename', 'phonecode'], 'required'],
				[['numcode', 'phonecode'], 'integer'],
				[['iso'], 'string', 'max' => 2],
				[['name', 'nicename'], 'string', 'max' => 80],
				[['iso3'], 'string', 'max' => 3]
			];
	 
	 }
	 
	 public function attributeLabels()
	 {
		 
		 return['id' => 'ID',
				'iso' => 'Iso',
				'name' => 'Name',
				'nicename' => 'Nicename',
				'iso3' => 'Iso3',
				'numcode' => 'Numcode',
				'phonecode' => 'Phonecode',
		 ];
		 
		 
	 }
 
 }

?>