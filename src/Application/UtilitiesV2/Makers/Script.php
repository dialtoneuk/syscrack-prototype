<?php

namespace Framework\Application\UtilitiesV2\Makers;

/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 31/08/2018
 * Time: 22:11
 */

use Framework\Application\UtilitiesV2\Conventions\FileData;
use Framework\Application\UtilitiesV2\FileOperator;

class Script extends Base
{

    public function before(FileData $template = null): void
    {

        if( $template == null )
            $template = FileOperator::pathDataInstance("resources/templates/template_script.module");

        parent::before($template);
    }
}