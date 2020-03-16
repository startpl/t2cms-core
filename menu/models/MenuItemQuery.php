<?php

namespace t2cms\menu\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * This is the ActiveQuery class for [[MenuItem]].
 *
 * @see MenuItem
 */
class MenuItemQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MenuItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MenuItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
