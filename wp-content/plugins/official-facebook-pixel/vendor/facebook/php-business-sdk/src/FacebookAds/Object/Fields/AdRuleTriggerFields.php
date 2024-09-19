<?php
 /*
 * Copyright (c) Meta Platforms, Inc. and affiliates.
 * All rights reserved.
 *
 * This source code is licensed under the license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace FacebookAds\Object\Fields;

use FacebookAds\Enum\AbstractEnum;

/**
 * This class is auto-generated.
 *
 * For any issues or feature requests related to this class, please let us know
 * on github and we'll fix in our codegen framework. We'll not be able to accept
 * pull request for this class.
 *
 */

class AdRuleTriggerFields extends AbstractEnum {

  const FIELD = 'field';
  const OPERATOR = 'operator';
  const TYPE = 'type';
  const VALUE = 'value';

  public function getFieldTypes() {
    return array(
      'field' => 'string',
      'operator' => 'Operator',
      'type' => 'Type',
      'value' => 'Object',
    );
  }
}
