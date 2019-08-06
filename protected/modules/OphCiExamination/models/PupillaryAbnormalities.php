<?php


namespace OEModule\OphCiExamination\models;

/**
 * This is the model class for table "et_ophciexamination_pupillary_abnormalities".
 *
 * The followings are the available columns in table:
 *
 * @property string $id
 * @property int $event_id
 * @property int $eye_id
 * @property datetime $no_pupillaryabnormalities_date_left
 * @property datetime $no_pupillaryabnormalities_date_right
 *
 * @property PupillaryAbnormalitiesEntry[] $entries
 * @property PupillaryAbnormalitiesEntry[] $entries_left
 * @property PupillaryAbnormalitiesEntry[] $entries_right
 */
class PupillaryAbnormalities extends \SplitEventTypeElement
{
    protected $auto_update_relations = true;
    protected $auto_validate_relations = true;

    public $widgetClass = 'OEModule\OphCiExamination\widgets\PupillaryAbnormalities';
    protected $default_from_previous = true;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'et_ophciexamination_pupillary_abnormalities';
    }

    public function behaviors()
    {
        return array(
            'PatientLevelElementBehaviour' => 'PatientLevelElementBehaviour',
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('event_id, no_pupillaryabnormalities_date_left, no_pupillaryabnormalities_date_right, entries', 'safe'),
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
            'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
            'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
            'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
            'entries' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\PupillaryAbnormalityEntry', 'element_id',),
            'entries_left' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\PupillaryAbnormalityEntry', 'element_id', 'on' => 'entries_left.eye_id = '.\Eye::LEFT),
            'entries_right' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\PupillaryAbnormalityEntry', 'element_id', 'on' => 'entries_right.eye_id = '.\Eye::RIGHT),
            'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'event_id' => 'Event',
            'no_pupillaryabnormalities_date_left' => 'No pupillary abnormalities',
            'no_pupillaryabnormalities_date_right' => 'No pupillary abnormalities',
        );
    }

    /**
     * Get list of available pupillary abnormalities for this element
     */
    public function getAbnormalityOptions()
    {
        $force = array();
        foreach ($this->entries_left as $entry) {
            $force[] = $entry->abnormality_id;
        }

        return OphCiExamination_PupillaryAbnormalities_Abnormality::model()->activeOrPk($force)->findAll();
    }

    public function afterSave()
    {
        foreach (array('left', 'right') as $eye_side) {
            if ($this->{'no_pupillaryabnormalities_date_' . $eye_side}) {
                foreach ($this->{'entries_' . $eye_side} as $entry) {
                    $entry->delete();
                }
            }
        }
        parent::afterSave();
    }

    /**
     * check either confirmation of no abnormalities or at least one abnormality entry for each side
     */
    public function afterValidate()
    {
        $model = str_replace('\\', '_', $this->elementType->class_name);
        $pa = $_POST[$model];

        foreach (array('left', 'right') as $side) {
            if (!$this->eyeHasSide($side, $pa['eye_id'])) {
                continue;
            }
            $has_entries = array_key_exists('entries_' . $side, $pa);
            $no_abnormalities = array_key_exists($side . '_no_pupillaryabnormalities', $pa);

            if (!$has_entries && !$no_abnormalities) {
                $this->addError($side, ucfirst($side) . ' side has no data.');
            }
        }

        return parent::afterValidate();
    }

    /**
     * Check for auditable changes
     *
     */
    protected function checkForAudits()
    {
        foreach (array('left', 'right') as $side) {
            if (!$this->eyeHasSide($side, $this->eye_id)) {
                continue;
            }

            if ($this->isAttributeDirty('no_pupillaryabnormalities_date_' . $side)) {
                if ($this->{'no_pupillaryabnormalities_date_' . $side}) {
                    $this->addAudit('set-nopupillaryabnormalitiesdate_' . $side);
                } else {
                    $this->addAudit('remove-nopupillaryabnormalitiesdate_' . $side);
                }
            }
        }

        return parent::checkForAudits();
    }

    protected function doAudit()
    {
        if ($this->isAtTip()) {
            parent::doAudit();
        }
    }

    /**
     * @param \BaseEventTypeElement $element
     */
    public function loadFromExisting($element)
    {
        foreach (array('left', 'right') as $side) {
            if (!$this->eyeHasSide($side, $this->eye_id)) {
                continue;
            }

            $this->{'no_pupillaryabnormalities_date_' . $side} = $element->{'no_pupillaryabnormalities_date_' . $side};

            $entries = $this->{'entries_' . $side};
            if (!$entries) {
                foreach ($element->{'entries_' . $side} as $entry) {
                    $new_entry = new PupillaryAbnormalityEntry();
                    $new_entry->loadFromExisting($entry);
                    $entries[] = $new_entry;
                }
            }
            $this->{'entries_' . $side} = $entries;
        }
        $this->originalAttributes = $this->getAttributes();
    }

    public function getSortedEntries($eye_side)
    {
        return $this->sortEntries($this->{'entries_' . $eye_side});
    }

    /**
     * Returns sorted PupillaryAbnormalityEntries
     * @param $entries
     * @return mixed
     */
    private function sortEntries($entries)
    {
        usort($entries, function ($a, $b) {
            if ($a->has_abnormality == $b->has_abnormality) {
                return 0;
            }
            return $a->has_abnormality < $b->has_abnormality ? 1 : -1;
        });

        return $entries;
    }

    public function getDisplayOrder($action)
    {
        return $action == 'view' ? 50 : parent::getDisplayOrder($action);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        foreach (array('left', 'right') as $side) {
            if (!$this->eyeHasSide($side, $this->eye_id)) {
                continue;
            }

            if ($this->{'no_pupillaryabnormalities_date_' . $side}) {
                return 'Patient has no known pupillary abnormalities.';
            } else {
                $entries = $this->sortEntries($this->{'entries_' . $side});
                return implode(' <br /> ', $entries);
            }

        }
    }
}