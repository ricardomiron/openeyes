<?php
/**
 * OpenEyes.
 *
 * (C) OpenEyes Foundation, 2016
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2016, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
class DefaultController extends BaseEventTypeController
{
    protected $show_element_sidebar = false;
    protected $max_document_size = 10485760;
    protected $max_content_length = 8388608;
    protected $allowed_file_types = array();

    /**
     * @var OphCoDocument_Sub_Types
     */
    protected $sub_type;

    protected static $action_types = array(
        'fileUpload' => self::ACTION_TYPE_FORM,
        'fileRemove' => self::ACTION_TYPE_FORM,
    );

    public function init()
    {
        $this->allowed_file_types = Yii::app()->params['OphCoDocument']['allowed_file_types'];
        $this->max_document_size = $this->return_bytes(ini_get('upload_max_filesize'));
        $this->max_content_length = $this->return_bytes(ini_get('upload_max_filesize'));

        $this->jsVars['max_document_size'] = $this->max_document_size;
        $this->jsVars['max_content_length'] = $this->max_content_length;
        $this->jsVars['allowed_file_types'] = array_values($this->allowed_file_types);

        return parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * Return bites based on the ini_get returns value e.g. 2M
     * @param $val
     * @return int|string
     */
    public function return_bytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch($last) {
            case 'g':
                $val *= (1024 * 1024 * 1024); //1073741824
                break;
            case 'm':
                $val *= (1024 * 1024); //1048576
                break;
            case 'k':
                $val *= 1024;
                break;
        }

        return $val;
    }

    /**
     * Returns the allowed file size in MB or bytes
     * @param bool $to_mb
     * @return int
     */
    public function getMaxDocumentSize($to_mb = true)
    {
        $size = $to_mb ? (number_format($this->max_document_size / 1048576, 0)) : $this->max_document_size;
        return $size;
    }

    /**
     * Returns the allowed file types (extensions)
     * @return array
     */
    public function getAllowedFileTypes()
    {
        return array_keys($this->allowed_file_types);
    }

    /**
     *
     */
    protected function initActionView()
    {
        parent::initActionView();
        $el = Element_OphCoDocument_Document::model()->findByAttributes(array('event_id' => $this->event->id));
        $this->sub_type = $el->sub_type;
        $this->title = $el->sub_type->name;
    }

    /**
     * @param $files
     * @param $index
     * @return null|string
     */
    private function documentErrorHandler($files, $index)
    {
        $message = NULL;

        switch ($files['Document']['error'][$index]) {
			case UPLOAD_ERR_OK:
			break;
			case UPLOAD_ERR_NO_FILE:
				$message = 'No file was uploaded!';
                return $message;
			break;
			case UPLOAD_ERR_INI_SIZE:
                $message = "The file you tried to upload exceeds the maximum allowed file size, which is " . $this->getMaxDocumentSize() ." MB ";
                return $message;
            break;
			case UPLOAD_ERR_FORM_SIZE:
				$message = 'The document\'s size is too large!';
                return $message;
			break;
			default:
				$message = 'Unknow error! Please try again!';
                return $message;
		}

		$finfo = new finfo(FILEINFO_MIME_TYPE);

        $file_mime = strtolower($finfo->file($files['Document']['tmp_name'][$index]));
        $extension = pathinfo($files['Document']['name'][$index], PATHINFO_EXTENSION);

		if (false === array_search($file_mime, $this->allowed_file_types, true)) {
            $message = 'Only the following file types can be uploaded: ' . ( implode(', ', $this->getAllowedFileTypes()) ) . '.';
            $message .= "\n\nFor reference, the type of the file you tried to upload is: <i>$extension</i>, which is mime type: <i>$file_mime</i>";
		}
        
        return $message;
    }

    /**
     * @param $tmp_name
     * @param $original_name
     * @return int|boolean
     */
    private function uploadFile($tmp_name, $original_name)
    {

        $p_file = ProtectedFile::createFromFile($tmp_name);
        $p_file->name = $original_name;

        if($p_file->save()) {
            unlink($tmp_name);
            return $p_file->id;
        }else{
            unlink($tmp_name);
            return false;
        }
    }

    /**
     * @return string
     */
    public function getHeaderBackgroundImage()
    {
        if ($this->sub_type) {
            if (in_array($this->sub_type->name, array('OCT', 'Photograph'))) {
                $asset_path = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.' . $this->event->eventType->class_name . '.assets')) . '/';
                return $asset_path . 'img/medium' . $this->sub_type->name . '.png';
            }
        }
    }

    /**
     *
     */
    public function actionFileUpload()
    {
        foreach($_FILES as $file)
        {
            $return_data = array();
            foreach (array('single_document_id', 'left_document_id', 'right_document_id') as $file_key) {
                if(isset($file["name"][$file_key]) && strlen($file["name"][$file_key])>0){
                    $handler = $this->documentErrorHandler($_FILES, $file_key);
                    if( $handler == NULL) {
                        $return_data[$file_key] = $this->uploadFile( $file["tmp_name"][$file_key], $file["name"][$file_key]);
                    } else {
                        $return_data = array(
                            's'     => 0,
                            'msg'   => $handler,
                            'index' => $file_key
                        );
                    }
                }

            }

            echo json_encode($return_data);
        }
    }

    /**
     * @param $mimetype
     * @return string
     */
    public function getTemplateForMimeType($mimetype)
    {
        if(strpos($mimetype, "image/") !== false){
            return 'image';
        }else{
            return 'object';
        }
    }

    /**
     * @param $element
     * @param $index
     */
    public function generateFileField($element, $index)
    {
        if($element->{$index."_id"} > 0){
            $this->renderPartial('form_'.$this->getTemplateForMimeType($element->{$index}->mimetype), array('element'=>$element, 'index'=>$index));
        }else {
            $this->renderPartial('form_empty_upload', array('index'=>$index));
        }
    }

}
