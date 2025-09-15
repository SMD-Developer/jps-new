<?php

namespace App\Traits;

trait CrudEventTrait
{
    public function beforeCreate($request){}
    public function beforeEdit(&$entity){}
    public function beforeStore($request,&$input){}
    public function afterStore($request, &$entity){}
    public function beforeUpdate($request, &$entity,&$input){}
    public function afterUpdate($request, &$entity){}
    public function beforeDestroy(&$entity){}
    public function afterDestroy(&$entity){}
    public function beforeShow(&$entity){}
}
