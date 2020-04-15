<?php

namespace t2cms\module\models;

/**
 * This is the ActiveQuery class for [[Module]].
 *
 * @see Module
 */
class ModuleQuery extends \yii\db\ActiveQuery
{
    
    public function active()
    {
        return $this->andWhere(['status' => Module::STATUS_ACTIVE]);
    }
    
    /**
     * {@inheritdoc}
     * @return Module[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Module|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
