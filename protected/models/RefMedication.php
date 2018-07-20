<?php

/**
 * This is the model class for table "ref_medication".
 *
 * The followings are the available columns in table 'ref_medication':
 * @property integer $id
 * @property string $source_type
 * @property string $source_subtype
 * @property string $preferred_term
 * @property string $short_term
 * @property string $preferred_code
 * @property string $vtm_term
 * @property string $vtm_code
 * @property string $vmp_term
 * @property string $vmp_code
 * @property string $amp_term
 * @property string $amp_code
 * @property string $deleted_date
 * @property string $last_modified_user_id
 * @property string $last_modified_date
 * @property string $created_user_id
 * @property string $created_date
 * @property int $will_ccopy
 *
 * The followings are the available model relations:
 * @property EventMedicationUse[] $eventMedicationUses
 * @property User $lastModifiedUser
 * @property User $createdUser
 * @property RefSet[] $refSets
 * @property RefMedicationsSearchIndex[] $refMedicationsSearchIndexes
 */
class RefMedication extends BaseActiveRecordVersioned
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ref_medication';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('source_type, preferred_term, preferred_code', 'required'),
			array('source_type, source_subtype, last_modified_user_id, created_user_id', 'length', 'max'=>10),
			array('preferred_term, short_term, preferred_code, vtm_term, vtm_code, vmp_term, vmp_code, amp_term, amp_code', 'length', 'max'=>255),
			array('deleted_date, last_modified_date, created_date', 'safe'),
			array('will_copy', 'numeric'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, source_type, source_subtype, preferred_term, preferred_code, vtm_term, vtm_code, vmp_term, vmp_code, amp_term, amp_code, deleted_date, last_modified_user_id, last_modified_date, created_user_id, created_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'eventMedicationUses' => array(self::HAS_MANY, EventMedicationUse::class, 'ref_medication_id'),
			'lastModifiedUser' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'createdUser' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'refSets' => array(self::MANY_MANY, RefSet::class, 'ref_medication_set(ref_medication_id, ref_set_id)'),
			'refMedicationsSearchIndexes' => array(self::HAS_MANY, RefMedicationsSearchIndex::class, 'ref_medication_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'source_type' => 'Source Type',
			'source_subtype' => 'Source Subtype',
			'preferred_term' => 'Preferred Term',
			'preferred_code' => 'Preferred Code',
			'vtm_term' => 'VTM Term',
			'vtm_code' => 'VTM Code',
			'vmp_term' => 'VMP Term',
			'vmp_code' => 'VMP Code',
			'amp_term' => 'AMP Term',
			'amp_code' => 'AMP Code',
			'deleted_date' => 'Deleted Date',
			'last_modified_user_id' => 'Last Modified User',
			'last_modified_date' => 'Last Modified Date',
			'created_user_id' => 'Created User',
			'created_date' => 'Created Date',
            'will_copy' => 'Will copy'
		);
	}

	public function isVTM()
    {
        return $this->vtm_term != '' && $this->vmp_term == '' && $this->amp_term == '';
    }

    public function isVMP()
    {
        return $this->vmp_term != '' && $this->amp_term == '';
    }

    public function isAMP()
    {
        return $this->amp_term != '';
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('source_type',$this->source_type,true);
		$criteria->compare('source_subtype',$this->source_subtype,true);
		$criteria->compare('preferred_term',$this->preferred_term,true);
		$criteria->compare('preferred_code',$this->preferred_code,true);
		$criteria->compare('vtm_term',$this->vtm_term,true);
		$criteria->compare('vtm_code',$this->vtm_code,true);
		$criteria->compare('vmp_term',$this->vmp_term,true);
		$criteria->compare('vmp_code',$this->vmp_code,true);
		$criteria->compare('amp_term',$this->amp_term,true);
		$criteria->compare('amp_code',$this->amp_code,true);
		$criteria->compare('deleted_date',$this->deleted_date,true);
		$criteria->compare('last_modified_user_id',$this->last_modified_user_id,true);
		$criteria->compare('last_modified_date',$this->last_modified_date,true);
		$criteria->compare('created_user_id',$this->created_user_id,true);
		$criteria->compare('created_date',$this->created_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RefMedication the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @return bool
     */

    public function getToBeCopiedIntoMedicationManagement()
    {
        $med_sets = array_map(function($e){ return $e->ref_set_id; }, \OEModule\OphCiExamination\models\MedicationManagementRefSet::model()->findAll());

        foreach ($this->refSets as $refSet) {
            if(in_array($refSet->id, $med_sets)) {
                return true;
            }
        }

        return false;
	}
}
