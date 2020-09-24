<?php

use OEModule\OphCiExamination\models\Element_OphCiExamination_AnteriorSegment_CCT;
use OEModule\OphCiExamination\models\Element_OphCiExamination_VisualAcuity;

/**
 * OpenEyes
 *
 * (C) OpenEyes Foundation, 2019
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2019, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
return array(
     'history' => array(
        'name' => 'History',
        'class_name' => 'BaseEventTypeElement',
        'event_type_id' => 1002,
        'display_order' => 1,
        'id' => 1,
        'default' => 1,
     ),
     'risks' => array(
         'name' => 'Risks',
         'class_name' => 'OEModule\OphCiExamination\models\HistoryRisks',
         'event_type_id' => 1002,
         'display_order' => 5,
     ),
     'pasthistory' => array(
          'name' => 'Past History',
          'class_name' => 'BaseEventTypeElement',
          'event_type_id' => 1002,
          'display_order' => 1,
          'parent_element_type_id' => 1,
     ),
     'visualfunction' => array(
          'name' => 'Visual function',
          'class_name' => 'BaseEventTypeElement',
          'event_type_id' => 1002,
          'display_order' => 3,
     ),
     'va' => array(
         'id' => 4119,
          'name' => 'Visual acuity',
          'class_name' => Element_OphCiExamination_VisualAcuity::class,
          'event_type_id' => 1002,
          'display_order' => 4,
     ),
    'inherited_event_element' => array(
        'name' => 'Inherited Event Element',
        'class_name' => 'BaseEventTypeElement',
        'event_type_id' => 1011,
        'display_order' => 20,
    ),
    'cct' => array(
        'name' => 'Anterior Segment CCT',
        'class_name' => Element_OphCiExamination_AnteriorSegment_CCT::class,
        'event_type_id' => 1002,
        'display_order' => 5,
    ),
     'ophhistory' =>   array(
            'id' => 311,
            'name' => 'History',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_History',
            'event_type_id' => 27,
            'display_order' => 10,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'History',
            'element_group_id' => 21,
        ),
    'refraction' => array(
            'id' => 312,
            'name' => 'Refraction',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Refraction',
            'event_type_id' => 27,
            'display_order' => 180,
            'default' => 1,
            'parent_element_type_id' => 361,
            'required' => 0,
            'group_title' => 'Refraction',
            'element_group_id' => 22,
        ),
    'visual_acuity' => array(
            'id' => 313,
            'name' => 'Visual Acuity',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_VisualAcuity',
            'event_type_id' => 27,
            'display_order' => 150,
            'default' => 1,
            'parent_element_type_id' => 361,
            'required' => 0,
            'group_title' => 'Visual Acuity',
            'element_group_id' => 22,
        ),
    'adnexal' =>  array(
            'id' => 314,
            'name' => 'Adnexal',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_AdnexalComorbidity',
            'event_type_id' => 27,
            'display_order' => 190,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Adnexal',
            'element_group_id' => 24,
        ),
    'anterior_segment' =>   array(
            'id' => 315,
            'name' => 'Anterior Segment',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_AnteriorSegment',
            'event_type_id' => 27,
            'display_order' => 220,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Anterior Segment',
            'element_group_id' => 25,
        ),
    'intraocular_pressure' =>   array(
            'id' => 316,
            'name' => 'Intraocular Pressure',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_IntraocularPressure',
            'event_type_id' => 27,
            'display_order' => 305,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Intraocular Pressure',
            'element_group_id' => 26,
        ),
    'macula' =>   array(
            'id' => 317,
            'name' => 'Macula',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_PosteriorPole',
            'event_type_id' => 27,
            'display_order' => 330,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Macula',
            'element_group_id' => 29,
        ),
    'ophthalmic_diagnoses' =>  array(
            'id' => 318,
            'name' => 'Ophthalmic Diagnoses',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Diagnoses',
            'event_type_id' => 27,
            'display_order' => 360,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Ophthalmic Diagnoses',
            'element_group_id' => 30,
        ),
    'investigation' =>   array(
            'id' => 319,
            'name' => 'Investigation',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Investigation',
            'event_type_id' => 27,
            'display_order' => 380,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Investigation',
            'element_group_id' => 31,
        ),
    'conclusion' =>   array(
            'id' => 320,
            'name' => 'Conclusion',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Conclusion',
            'event_type_id' => 27,
            'display_order' => 520,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Conclusion',
            'element_group_id' => 37,
        ),
    'cataract_surgical_management' =>   array(
            'id' => 321,
            'name' => 'Cataract Surgical Management',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_CataractSurgicalManagement_Archive',
            'event_type_id' => 27,
            'display_order' => 440,
            'default' => 1,
            'parent_element_type_id' => 357,
            'required' => 0,
            'group_title' => 'Cataract Surgical Management',
            'element_group_id' => NULL,
        ),
    'drops' =>   array(
            'id' => 335,
            'name' => 'Drops',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Dilation',
            'event_type_id' => 27,
            'display_order' => 300,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Drops',
            'element_group_id' => 27,
        ),
    'comorbities' =>   array(
            'id' => 353,
            'name' => 'Comorbidities',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Comorbidities',
            'event_type_id' => 27,
            'display_order' => 20,
            'default' => 1,
            'parent_element_type_id' => 311,
            'required' => 0,
            'group_title' => 'Comorbidities',
            'element_group_id' => 21,
        ),
    'gonioscopy' =>   array(
            'id' => 354,
            'name' => 'Gonioscopy',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Gonioscopy',
            'event_type_id' => 27,
            'display_order' => 240,
            'default' => 1,
            'parent_element_type_id' => 315,
            'required' => 0,
            'group_title' => 'Gonioscopy',
            'element_group_id' => 25,
        ),
    'optic_disc' =>  array(
            'id' => 355,
            'name' => 'Optic Disc',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_OpticDisc',
            'event_type_id' => 27,
            'display_order' => 320,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Optic Disc',
            'element_group_id' => 28,
        ),
    'anteriorCCT' =>   array(
            'id' => 356,
            'name' => 'CCT',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_AnteriorSegment_CCT',
            'event_type_id' => 27,
            'display_order' => 250,
            'default' => 1,
            'parent_element_type_id' => 315,
            'required' => 0,
            'group_title' => 'CCT',
            'element_group_id' => 25,
        ),
    'clinical_management' =>  array(
            'id' => 357,
            'name' => 'Clinical Management',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Management',
            'event_type_id' => 27,
            'display_order' => 430,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Clinical Management',
            'element_group_id' => 34,
        ),
    'followup' =>   array(
            'id' => 358,
            'name' => 'Follow-up',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_ClinicOutcome',
            'event_type_id' => 27,
            'display_order' => 510,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Follow-up',
            'element_group_id' => 36,
        ),
    'glaucoma_risk' =>   array(
            'id' => 359,
            'name' => 'Glaucoma Risk',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_GlaucomaRisk',
            'event_type_id' => 27,
            'display_order' => 410,
            'default' => 0,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Glaucoma Risk',
            'element_group_id' => 32,
        ),
    'ophciRisks' =>   array(
            'id' => 360,
            'name' => 'Risks',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Risks',
            'event_type_id' => 27,
            'display_order' => 500,
            'default' => 0,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Risks',
            'element_group_id' => 35,
        ),
    'pupils' =>  array(
            'id' => 361,
            'name' => 'Pupils',
            'class_name' => 'OEModule\OphCiExamination\models\PupillaryAbnormalities',
            'event_type_id' => 27,
            'display_order' => 125,
            'default' => 0,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Pupils',
            'element_group_id' => 22,
        ),
    'dr_grading' =>  array(
            'id' => 388,
            'name' => 'DR Grading',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_DRGrading',
            'event_type_id' => 27,
            'display_order' => 340,
            'default' => 1,
            'parent_element_type_id' => 317,
            'required' => 0,
            'group_title' => 'DR Grading',
            'element_group_id' => 29,
        ),
    'laser_management' =>   array(
            'id' => 389,
            'name' => 'Laser Management',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_LaserManagement',
            'event_type_id' => 27,
            'display_order' => 470,
            'default' => 1,
            'parent_element_type_id' => 357,
            'required' => 0,
            'group_title' => 'Laser Management',
            'element_group_id' => 34,
        ),
    'injection_management' =>   array(
            'id' => 390,
            'name' => 'Injection Management',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_InjectionManagement',
            'event_type_id' => 27,
            'display_order' => 480,
            'default' => 1,
            'parent_element_type_id' => 357,
            'required' => 0,
            'group_title' => 'Injection Management',
            'element_group_id' => 34,
        ),
    'injection_management_complex' =>   array(
            'id' => 391,
            'name' => 'Injection Management',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_InjectionManagementComplex',
            'event_type_id' => 27,
            'display_order' => 490,
            'default' => 1,
            'parent_element_type_id' => 357,
            'required' => 0,
            'group_title' => 'Injection Management',
            'element_group_id' => 34,
        ),
    'oct_manual' =>  array(
            'id' => 392,
            'name' => 'OCT (manual)',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_OCT',
            'event_type_id' => 27,
            'display_order' => 390,
            'default' => 1,
            'parent_element_type_id' => 319,
            'required' => 0,
            'group_title' => 'OCT',
            'element_group_id' => 31,
        ),
    'bleb_assessment' =>  array(
            'id' => 408,
            'name' => 'Bleb Assessment',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_BlebAssessment',
            'event_type_id' => 27,
            'display_order' => 270,
            'default' => 1,
            'parent_element_type_id' => 315,
            'required' => NULL,
            'group_title' => 'Bleb Assessment',
            'element_group_id' => 25,
        ),
    'colour_vision' =>   array(
            'id' => 409,
            'name' => 'Colour Vision',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_ColourVision',
            'event_type_id' => 27,
            'display_order' => 170,
            'default' => 1,
            'parent_element_type_id' => 361,
            'required' => 0,
            'group_title' => 'Colour Vision',
            'element_group_id' => 22,
        ),
    'glaucoma_overall_plan' =>  array(
            'id' => 410,
            'name' => 'Glaucoma Overall Plan',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_OverallManagementPlan',
            'event_type_id' => 27,
            'display_order' => 450,
            'default' => 1,
            'parent_element_type_id' => 357,
            'required' => NULL,
            'group_title' => 'Glaucoma Overall Plan',
            'element_group_id' => 34,
        ),
    'glaucoma_current_plan' =>    array(
            'id' => 411,
            'name' => 'Glaucoma Current Plan',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_CurrentManagementPlan',
            'event_type_id' => 27,
            'display_order' => 460,
            'default' => 1,
            'parent_element_type_id' => 357,
            'required' => NULL,
            'group_title' => 'Glaucoma Current Plan',
            'element_group_id' => 34,
        ),
    'further_findings' =>   array(
            'id' => 417,
            'name' => 'Further Findings',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_FurtherFindings',
            'event_type_id' => 27,
            'display_order' => 370,
            'default' => 1,
            'parent_element_type_id' => 318,
            'required' => NULL,
            'group_title' => 'Further Findings',
            'element_group_id' => 30,
        ),
    'near_visual_acuity' =>   array(
            'id' => 419,
            'name' => 'Near Visual Acuity',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_NearVisualAcuity',
            'event_type_id' => 27,
            'display_order' => 160,
            'default' => 1,
            'parent_element_type_id' => 361,
            'required' => 0,
            'group_title' => 'Near Visual Acuity',
            'element_group_id' => 22,
        ),
    'examination_allergies' =>   array(
            'id' => 420,
            'name' => 'Allergies',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Allergy',
            'event_type_id' => 27,
            'display_order' => 30,
            'default' => 0,
            'parent_element_type_id' => 311,
            'required' => 0,
            'group_title' => 'Allergies',
            'element_group_id' => 21,
        ),
    'post_op_complications' =>   array(
            'id' => 428,
            'name' => 'Post-Op Complications',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_PostOpComplications',
            'event_type_id' => 27,
            'display_order' => 530,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Post-Op Complications',
            'element_group_id' => 38,
        ),
    'fundus' =>   array(
            'id' => 430,
            'name' => 'Fundus',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Fundus',
            'event_type_id' => 27,
            'display_order' => 350,
            'default' => 1,
            'parent_element_type_id' => 317,
            'required' => NULL,
            'group_title' => 'Fundus',
            'element_group_id' => 29,
        ),
    'history_risk' =>   array(
            'id' => 431,
            'name' => 'Risk',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_HistoryRisk',
            'event_type_id' => 27,
            'display_order' => 80,
            'default' => 0,
            'parent_element_type_id' => 311,
            'required' => NULL,
            'group_title' => 'Risk',
            'element_group_id' => 21,
        ),
    'optometrist_comments' =>   array(
            'id' => 432,
            'name' => 'Optometrist Comments',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_OptomComments',
            'event_type_id' => 27,
            'display_order' => 540,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Optometrist Comments',
            'element_group_id' => 39,
        ),
    'pcr_risk' =>   array(
            'id' => 440,
            'name' => 'PCR Risk',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_PcrRisk',
            'event_type_id' => 27,
            'display_order' => 420,
            'default' => 0,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'PCR Risk',
            'element_group_id' => 33,
        ),
    'keratoconus_monitoring' =>    array(
            'id' => 441,
            'name' => 'Keratoconus Monitoring',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_CXL_History',
            'event_type_id' => 27,
            'display_order' => 260,
            'default' => 1,
            'parent_element_type_id' => 315,
            'required' => NULL,
            'group_title' => 'Keratoconus Monitoring',
            'element_group_id' => 25,
        ),
    'corneal_tomography' =>    array(
            'id' => 442,
            'name' => 'Corneal Tomography',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Keratometry',
            'event_type_id' => 27,
            'display_order' => 400,
            'default' => 1,
            'parent_element_type_id' => 319,
            'required' => NULL,
            'group_title' => 'Corneal Tomography',
            'element_group_id' => 31,
        ),
    'specular_microscopy' =>   array(
            'id' => 443,
            'name' => 'Specular Microscopy',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Specular_Microscopy',
            'event_type_id' => 27,
            'display_order' => 280,
            'default' => 1,
            'parent_element_type_id' => 441,
            'required' => NULL,
            'group_title' => 'Specular Microscopy',
            'element_group_id' => 25,
        ),
    'slit_lamp' =>   array(
            'id' => 444,
            'name' => 'KC/CXL-Specific Slit Lamp',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Slit_Lamp',
            'event_type_id' => 27,
            'display_order' => 290,
            'default' => 1,
            'parent_element_type_id' => 441,
            'required' => NULL,
            'group_title' => 'KC/CXL-Specific Slit Lamp',
            'element_group_id' => 25,
        ),
    'medical_lids' =>   array(
            'id' => 447,
            'name' => 'Lids Medical',
            'class_name' => 'OEModule\OphCiExamination\models\MedicalLids',
            'event_type_id' => 27,
            'display_order' => 210,
            'default' => 1,
            'parent_element_type_id' => 314,
            'required' => NULL,
            'group_title' => 'Lids Medical',
            'element_group_id' => 24,
        ),
    'family_history' =>   array(
            'id' => 448,
            'name' => 'Family History',
            'class_name' => 'OEModule\OphCiExamination\models\FamilyHistory',
            'event_type_id' => 27,
            'display_order' => 110,
            'default' => 1,
            'parent_element_type_id' => 311,
            'required' => NULL,
            'group_title' => 'Family History',
            'element_group_id' => 21,
        ),
    'allergies' =>  array(
            'id' => 449,
            'name' => 'Allergies',
            'class_name' => 'OEModule\OphCiExamination\models\Allergies',
            'event_type_id' => 27,
            'display_order' => 50,
            'default' => 0,
            'parent_element_type_id' => 311,
            'required' => 0,
            'group_title' => 'Allergies',
            'element_group_id' => 21,
        ),
    'social_history' =>   array(
            'id' => 450,
            'name' => 'Social History',
            'class_name' => 'OEModule\OphCiExamination\models\SocialHistory',
            'event_type_id' => 27,
            'display_order' => 120,
            'default' => 0,
            'parent_element_type_id' => 311,
            'required' => 0,
            'group_title' => 'Social History',
            'element_group_id' => 21,
        ),
    'ophthalmic_surgical_history' =>   array(
            'id' => 451,
            'name' => 'Ophthalmic Surgical History',
            'class_name' => 'OEModule\OphCiExamination\models\PastSurgery',
            'event_type_id' => 27,
            'display_order' => 60,
            'default' => 0,
            'parent_element_type_id' => 311,
            'required' => 0,
            'group_title' => 'Surgical History',
            'element_group_id' => 21,
        ),
    'surgical_lids' =>   array(
            'id' => 452,
            'name' => 'Lids Surgical',
            'class_name' => 'OEModule\OphCiExamination\models\SurgicalLids',
            'event_type_id' => 27,
            'display_order' => 200,
            'default' => 0,
            'parent_element_type_id' => 314,
            'required' => 0,
            'group_title' => 'Lids Surgical',
            'element_group_id' => 24,
        ),
    'systemic_diagnoses' =>  array(
            'id' => 453,
            'name' => 'Systemic Diagnoses',
            'class_name' => 'OEModule\OphCiExamination\models\SystemicDiagnoses',
            'event_type_id' => 27,
            'display_order' => 40,
            'default' => 0,
            'parent_element_type_id' => 311,
            'required' => 0,
            'group_title' => 'Systemic Diagnoses',
            'element_group_id' => 21,
        ),
    'history_risks' =>   array(
            'id' => 454,
            'name' => 'Risks',
            'class_name' => 'OEModule\OphCiExamination\models\HistoryRisks',
            'event_type_id' => 27,
            'display_order' => 90,
            'default' => 0,
            'parent_element_type_id' => 311,
            'required' => 0,
            'group_title' => 'Risks',
            'element_group_id' => 21,
        ),
    'medication_history' =>   array(
            'id' => 456,
            'name' => 'Medication History',
            'class_name' => 'OEModule\OphCiExamination\models\HistoryMedications',
            'event_type_id' => 27,
            'display_order' => 70,
            'default' => 0,
            'parent_element_type_id' => 311,
            'required' => 0,
            'group_title' => 'Medications',
            'element_group_id' => 21,
        ),
    'observations' =>  array(
            'id' => 457,
            'name' => 'Observations',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Observations',
            'event_type_id' => 27,
            'display_order' => 140,
            'default' => 0,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => 'Observations',
            'element_group_id' => 23,
        ),
    'van_herick' =>   array(
            'id' => 459,
            'name' => 'Van Herick',
            'class_name' => 'OEModule\OphCiExamination\models\VanHerick',
            'event_type_id' => 27,
            'display_order' => 230,
            'default' => 1,
            'parent_element_type_id' => 315,
            'required' => NULL,
            'group_title' => 'Van Herick',
            'element_group_id' => 25,
        ),
    'cvi_status' =>   array(
            'id' => 460,
            'name' => 'CVI status',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_CVI_Status',
            'event_type_id' => 27,
            'display_order' => 100,
            'default' => 0,
            'parent_element_type_id' => 311,
            'required' => 0,
            'group_title' => 'CVI status',
            'element_group_id' => 21,
        ),
    'iop_history' =>   array(
            'id' => 462,
            'name' => 'IOP History',
            'class_name' => 'OEModule\OphCiExamination\models\HistoryIOP',
            'event_type_id' => 27,
            'display_order' => 310,
            'default' => 0,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => NULL,
            'element_group_id' => 82,
        ),
    'contacts' =>   array(
            'id' => 463,
            'name' => 'Contacts',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Contacts',
            'event_type_id' => 27,
            'display_order' => 130,
            'default' => 0,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => NULL,
            'element_group_id' => 83,
        ),
    'communication_preferences' => array(
            'id' => 464,
            'name' => 'Communication Preferences',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_CommunicationPreferences',
            'event_type_id' => 27,
            'display_order' => 10,
            'default' => 0,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => NULL,
            'element_group_id' => 84,
        ),
    'oct' =>   array(
            'id' => 467,
            'name' => 'OCT',
            'class_name' => 'OEModule\OphCiExamination\models\OCT',
            'event_type_id' => 27,
            'display_order' => 395,
            'default' => 0,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => NULL,
            'element_group_id' => 31,
        ),
    'cataract_surgical_management' => array(
            'id' => 468,
            'name' => 'Cataract Surgical Management',
            'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_CataractSurgicalManagement',
            'event_type_id' => 27,
            'display_order' => 440,
            'default' => 1,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => NULL,
            'element_group_id' => 34,
        ),
    'medication_management' =>   array(
            'id' => 473,
            'name' => 'Medication Management',
            'class_name' => 'OEModule\OphCiExamination\models\MedicationManagement',
            'event_type_id' => 27,
            'display_order' => 440,
            'default' => 0,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => NULL,
            'element_group_id' => 34,
        ),
    'systemic_surgical_history' =>   array(
            'id' => 474,
            'name' => 'Systemic Surgical History',
            'class_name' => 'OEModule\OphCiExamination\models\SystemicSurgery',
            'event_type_id' => 27,
            'display_order' => 50,
            'default' => 0,
            'parent_element_type_id' => NULL,
            'required' => 0,
            'group_title' => NULL,
            'element_group_id' => 21,
        ),
    'procedure_list' => array(
        'id' => 475,
        'name' => 'Procedure List',
        'class_name' => 'Element_OphCiTheatreadmission_ProcedureList',
        'event_type_id' => 44,
        'display_order' => 1,
        'default' => 1,
        'parent_element_type_id' => NULL,
        'required' => 0,
        'group_title' => NULL,
        'element_group_id' => NULL,
        ),
    'admission' => array(
        'id' => 476,
        'name' => 'Admission',
        'class_name' => 'Element_OphCiTheatreadmission_AdmissionChecklist',
        'event_type_id' => 44,
        'display_order' => 2,
        'default' => 1,
        'parent_element_type_id' => NULL,
        'required' => 0,
        'group_title' => NULL,
        'element_group_id' => NULL,
        ),
    'case_note' => array(
        'id' => 477,
        'name' => 'Case Notes',
        'class_name' => 'Element_OphCiTheatreadmission_CaseNote',
        'event_type_id' => 44,
        'display_order' => 3,
        'default' => 1,
        'parent_element_type_id' => NULL,
        'required' => 0,
        'group_title' => NULL,
        'element_group_id' => NULL,
        ),
    'documentation' => array(
        'id' => 478,
        'name' => 'Documentation',
        'class_name' => 'Element_OphCiTheatreadmission_Documentation',
        'event_type_id' => 44,
        'display_order' => 4,
        'default' => 1,
        'parent_element_type_id' => NULL,
        'required' => 0,
        'group_title' => NULL,
        'element_group_id' => NULL,
        ),
    'clinical_assessment' => array(
        'id' => 479,
        'name' => 'Clinical Assessment',
        'class_name' => 'Element_OphCiTheatreadmission_ClinicalAssessment',
        'event_type_id' => 44,
        'display_order' => 5,
        'default' => 1,
        'parent_element_type_id' => NULL,
        'required' => 0,
        'group_title' => NULL,
        'element_group_id' => NULL,
        ),
    'nursing_practitioner_assessment' => array(
        'id' => 480,
        'name' => 'Nursing/Practitioner Assessment',
        'class_name' => 'Element_OphCiTheatreadmission_NursingAssessment',
        'event_type_id' => 44,
        'display_order' => 6,
        'default' => 1,
        'parent_element_type_id' => NULL,
        'required' => 0,
        'group_title' => NULL,
        'element_group_id' => NULL,
        ),
    'dvt' => array(
        'id' => 481,
        'name' => 'DVT',
        'class_name' => 'Element_OphCiTheatreadmission_DVT',
        'event_type_id' => 44,
        'display_order' => 7,
        'default' => 1,
        'parent_element_type_id' => NULL,
        'required' => 0,
        'group_title' => NULL,
        'element_group_id' => NULL,
        ),
    'patient_support' => array(
        'id' => 482,
        'name' => 'Patient Support',
        'class_name' => 'Element_OphCiTheatreadmission_PatientSupport',
        'event_type_id' => 44,
        'display_order' => 8,
        'default' => 1,
        'parent_element_type_id' => NULL,
        'required' => 0,
        'group_title' => NULL,
        'element_group_id' => NULL,
        ),
    'discharge' => array(
        'id' => 483,
        'name' => 'Discharge',
        'class_name' => 'Element_OphCiTheatreadmission_Discharge',
        'event_type_id' => 44,
        'display_order' => 9,
        'default' => 1,
        'parent_element_type_id' => NULL,
        'required' => 0,
        'group_title' => NULL,
        'element_group_id' => NULL,
    ),

/*
 'elementType5' => array(
      'name' => 'Mini-refraction',
      'class_name' => 'ElementMiniRefraction',
      'event_type_id' => 4,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 ),
 'elementType6' => array(
      'name' => 'Visual fields',
      'class_name' => 'ElementVisualFields',
      'event_type_id' => 4,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 ),
 'elementType7' => array(
      'name' => 'Extraocular movements',
      'class_name' => 'ElementExtraocularMovements',
      'event_type_id' => 4,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 ),
 'elementType8' => array(
      'name' => 'Cranial nervers',
      'class_name' => 'ElementCranialNervers',
      'event_type_id' => 4,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 ),
 'elementType9' => array(
      'name' => 'Orbital examination',
      'class_name' => 'ElementOrbitalExamination',
      'event_type_id' => 4,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 ),
 'elementType10' => array(
      'name' => 'Anterior segment',
      'class_name' => 'ElementAnteriorSegment',
      'event_type_id' => 4,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 ),
 'elementType11' => array(
      'name' => 'Anterior segment drawing',
      'class_name' => 'ElementAnteriorSegmentDrawing',
      'event_type_id' => 4,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 ),
 'elementType12' => array(
      'name' => 'Gonioscopy',
      'class_name' => 'ElementGonioscopy',
      'event_type_id' => 1,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 ),
 'elementType13' => array(
      'name' => 'intraocular pressure',
      'class_name' => 'ElementIntraocularPressure',
      'event_type_id' => 1,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 ),
 'elementType14' => array(
      'name' => 'Posterior segment',
      'class_name' => 'ElementPosteriorSegment',
      'event_type_id' => 4,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 ),
 'elementType15' => array(
      'name' => 'Posterior segment drawing',
      'class_name' => 'ElementPosteriorSegmentDrawing',
      'event_type_id' => 4,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 ),
 'elementType16' => array(
      'name' => 'Conclusion',
      'class_name' => 'ElementConclusion',
      'event_type_id' => 4,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 ),
 'elementType17' => array(
      'name' => 'POH',
      'class_name' => 'ElementPOH',
      'event_type_id' => 4,
      'display_order' => 1,
      'parent_element_type_id' => 1,
 )
*/
);
