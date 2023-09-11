<?php

declare(strict_types=1);

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Frans Saris <franssaris@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
namespace Fixpunkt\FpMasterquiz\ViewHelpers;

use Closure;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;


class TrueForJavaScriptViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    protected $escapeOutput = false;

    public static function renderStatic(
        array $arguments, Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    )
    {
        $value = $arguments['value'];
        return ($value == '1')?'true':'false';
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('value', 'string|null', '', false, null);
    }
}
