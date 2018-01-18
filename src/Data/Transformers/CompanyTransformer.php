<?php

namespace App\Data\Transformers;

use App\Data\Transformers\BaseTransformer;
use App\Data\Transformers\RoleTransformer;
use App\Data\Queries\Query;

class CompanyTransformer extends BaseTransformer {
    protected function getRelationTransformer( $relation ) {
        switch( $relation ) {
            case 'roles': {
                return new RoleTransformer();
            }
        }
        return null;
    }

    public function transform( $data, ?Query $query ) {
        $company = $data; 
        $output = [
            'id' => (int) $company->id,
            'nif' => (string) $company->nif,
            'name' => (string) $company->name,
            'email' => (string) $company->email,
            'address' => $company->address !== null ? ( (string)$company->address ) : null,
            'phone' => $company->phone !== null ? ( (string)$company->phone ) : null,
            'logo_url' => $company->logo_url !== null ? ( (string)$company->logo_url ) : null,
            'created_at' => $company->created_at,
            'updated_at' => $company->updated_at
        ];

        $output = $this->includeRelations( $output, $data, $query );        
        return $this->hideFields( $output, $query );
    }
}