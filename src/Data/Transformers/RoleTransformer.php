<?php

namespace App\Data\Transformers;

use App\Data\Transformers\BaseTransformer;
use App\Data\Transformers\CompanyTransformer;
use App\Data\Queries\Query;

class RoleTransformer extends BaseTransformer {
    protected function getRelationTransformer( $relation ) {
        switch( $relation ) {
            case "company": {
                return new CompanyTransformer();
            }
        }

        return null;
    }

    public function _transform( $role, ?Query $query ) {
        return [
            'id' => (int) $role->id,
            'role_name' => (string) $role->role_name,
            'company_id' =>  $role->company_id !== null ? (int)$role->company_id : null, 
            'created_at' => $role->created_at,
            'updated_at' => $role->updated_at
        ];
    }
}