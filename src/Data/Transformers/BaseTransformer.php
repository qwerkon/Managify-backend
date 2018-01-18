<?php

namespace App\Data\Transformers;

use App\Data\Queries\Query;

abstract class BaseTransformer {
    abstract public function transform( $data, ?Query $query );

    protected function hideFields( $data, ?Query $query ) {
        if( $query === null ) {
            return $data;
        }
        
        $output = [];
        $toShow = $query->getFields();
        $toHide = $query->getHidden();
        foreach( $data as $key => $value ) {
            if( !empty( $toShow ) ) {
                if( !isset( $toShow[ $key ] ) ) {
                    continue;
                }
            }
            
            if( !isset( $toHide[ $key ] ) ) {
                $output[ $key ] = $value;
            }
        }

        return $output;
    }
}