<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\DatabaseMigrationService;

class IndexEntity extends \Google\Collection
{
  protected $collection_key = 'tableColumns';
  /**
   * @var array[]
   */
  public $customFeatures = [];
  /**
   * @var string
   */
  public $name;
  /**
   * @var string[]
   */
  public $tableColumns = [];
  /**
   * @var string
   */
  public $type;
  /**
   * @var bool
   */
  public $unique;

  /**
   * @param array[]
   */
  public function setCustomFeatures($customFeatures)
  {
    $this->customFeatures = $customFeatures;
  }
  /**
   * @return array[]
   */
  public function getCustomFeatures()
  {
    return $this->customFeatures;
  }
  /**
   * @param string
   */
  public function setName($name)
  {
    $this->name = $name;
  }
  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }
  /**
   * @param string[]
   */
  public function setTableColumns($tableColumns)
  {
    $this->tableColumns = $tableColumns;
  }
  /**
   * @return string[]
   */
  public function getTableColumns()
  {
    return $this->tableColumns;
  }
  /**
   * @param string
   */
  public function setType($type)
  {
    $this->type = $type;
  }
  /**
   * @return string
   */
  public function getType()
  {
    return $this->type;
  }
  /**
   * @param bool
   */
  public function setUnique($unique)
  {
    $this->unique = $unique;
  }
  /**
   * @return bool
   */
  public function getUnique()
  {
    return $this->unique;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(IndexEntity::class, 'Google_Service_DatabaseMigrationService_IndexEntity');
