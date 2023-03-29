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

namespace Google\Service\CloudRetail;

class GoogleCloudRetailV2AttributesConfig extends \Google\Model
{
  /**
   * @var string
   */
  public $attributeConfigLevel;
  protected $catalogAttributesType = GoogleCloudRetailV2CatalogAttribute::class;
  protected $catalogAttributesDataType = 'map';
  public $catalogAttributes = [];
  /**
   * @var string
   */
  public $name;

  /**
   * @param string
   */
  public function setAttributeConfigLevel($attributeConfigLevel)
  {
    $this->attributeConfigLevel = $attributeConfigLevel;
  }
  /**
   * @return string
   */
  public function getAttributeConfigLevel()
  {
    return $this->attributeConfigLevel;
  }
  /**
   * @param GoogleCloudRetailV2CatalogAttribute[]
   */
  public function setCatalogAttributes($catalogAttributes)
  {
    $this->catalogAttributes = $catalogAttributes;
  }
  /**
   * @return GoogleCloudRetailV2CatalogAttribute[]
   */
  public function getCatalogAttributes()
  {
    return $this->catalogAttributes;
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
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudRetailV2AttributesConfig::class, 'Google_Service_CloudRetail_GoogleCloudRetailV2AttributesConfig');
