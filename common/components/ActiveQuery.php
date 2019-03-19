<?php

namespace common\components;


use common\models\Company;

class ActiveQuery extends \yii\db\ActiveQuery
{

    public function isActive($alias = '')
    {
        $alias = $alias ? "$alias." : "";

        return $this->andWhere(["{$alias}is_deleted" => 0]);
    }

    public function isDeleted()
    {
        return $this->andWhere(['is_deleted' => 1]);
    }

    public function andCompanyAscendantScope($company, $alias = null)
    {
        if($company == null) return $this;

        $parent_id = Company::find()->select(['parent_id'])->where(['id' => $company])->scalar();

        $alias = $alias ? "$alias." : "";

        return $this->andWhere([
            'or',
            ['in', "{$alias}company_id", array_filter([$company, $parent_id])],
            ['is', "{$alias}company_id", null]
        ]);
    }

    public function andCompanyDescendantScope($company, $alias = null)
    {
        if($company == null) return $this;

        $children_ids = Company::find()->select(['id'])->isActive()->andWhere(['parent_id' => $company])->column();

        $children_ids[] = $company;

        $alias = $alias ? "$alias." : "";

        return $this->andWhere(["{$alias}company_id" => $children_ids]);
    }

}