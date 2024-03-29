<?php

/**
 * This is the model class for table "system_language".
 *
 * The followings are the available columns in table 'system_language':
 * @property integer $language_id
 * @property string $lang
 * @property string $bezeichnung
 */
class SystemLanguage extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName()	{
		return 'system_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lang, bezeichnung', 'required'),
			array('lang', 'length', 'max'=>5),
			array('bezeichnung', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('language_id, lang, bezeichnung', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'language_id' => 'Language',
			'lang' => 'Lang',
			'bezeichnung' => 'Bezeichnung',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('language_id', $this->language_id);
		$criteria->compare('lang', $this->lang, true);
		$criteria->compare('bezeichnung', $this->bezeichnung, true);

		return new CActiveDataProvider($this,
			array(
				'criteria'=>$criteria,
			)
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SystemLanguage the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function getDeutsch() {
		return Yii::app()->db->cache(0)->createCommand()
			->select('*')
			->from('system_language')
			->where('lang = "de"')
			->queryAll();
	}

	public static function getAlleSprachen() {
		return self::model()->cache(CACHETIME_S)->findAll();
	}

	public static function getSpracheById($spracheId) {
		return self::model()->cache(CACHETIME_S)->findByPk($spracheId);
	}

	public static function getSpracheByLang($sprachkuerzel) {
		return self::model()->cache(CACHETIME_S)->findByAttributes(array('lang' => $sprachkuerzel));
	}
}
