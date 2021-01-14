<?php

/**
 * (C) Apperta Foundation, 2020
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (C) 2020, Apperta Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */

namespace OEModule\OphCiExamination\tests\unit\components;

use OEModule\OphCiExamination\components\OphCiExamination_API;
use OEModule\OphCiExamination\components\traits\Refraction_API;
use OEModule\OphCiExamination\components\traits\VisualAcuity_API;
use PHPUnit\Framework\TestCase;

/**
 * Class FixtureLess_OphCiExamination_APITest
 *
 * @package OEModule\OphCiExamination\tests\unit\components
 * @covers \OEModule\OphCiExamination\components\OphCiExamination_API
 * @group sample-data
 * @group strabismus
 * @group visual-acuity
 * @group refraction
 */
class FixtureLess_OphCiExamination_APITest extends TestCase
{
    public function expected_traits_provider()
    {
        return [
            [VisualAcuity_API::class],
            [Refraction_API::class]
        ];
    }

    /**
     * @test
     * @dataProvider expected_traits_provider
     * @param $expected_trait
     */
    public function trait_usage($expected_trait)
    {
        $this->assertContains(
            $expected_trait,
            \OEDbTestCase::classUsesRecursive(OphCiExamination_API::class),
            'Examination API should be using this trait'
        );
    }
}
