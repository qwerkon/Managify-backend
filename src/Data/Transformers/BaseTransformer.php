<?php

namespace App\Data\Transformers;

use App\Data\Queries\Query;

abstract class BaseTransformer {
    abstract public function transform( $data, ?Query $query );

    abstract protected function getRelationTransformer( $relation );

    protected function includeRelations( $output, $data, ?Query $query ) {
        if( $query !== null ) {
            foreach( $query->getInclude() as $relation ) {
                $relationData = $data[ $relation ];
                $transformer = $this->getRelationTransformer( $relation );

                if( $transformer !== null ) {
                    if( $relationData instanceof \Illuminate\Database\Eloquent\Collection ) {
                        $items = [];
                        foreach( $relationData as $item ) {
                            array_push( $items, $transformer->transform( $item, null ) );
                        }
                        $output[ $relation ] = $items;
                    } else {
                        $relationData = $transformer->transform( $relationData, null );
                        $output[ $relation ] = $relationData;
                    }
                }
            }
        }

        return $output;
    }

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