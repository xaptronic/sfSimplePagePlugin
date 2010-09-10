<?php

/**
 * Base actions for the sfSimplePagePlugin sfSimplePage module.
 * 
 * @package     sfSimplePagePlugin
 * @subpackage  sfSimplePage
 * @author      Your name here
 * @version     SVN: $Id: BaseActions.class.php 12628 2008-11-04 14:43:36Z Kris.Wallsmith $
 */
abstract class BasesfSimplePageActions extends sfActions
{
  public function executeIndex($request)
  {
    // set template_path from path_info
    $pathinfo = $request->getPathInfo() ;
    $route_prefix = sfConfig::get("app_sf_simple_page_plugin_route_prefix","static") ;

    //remove  trailing slashes
    $route_prefix = '/'. trim( $route_prefix, '/' ) ;
    $pathinfo = preg_replace( "#^{$route_prefix}#", "", $pathinfo ) ;

    // prepare component file parameter
    $this->file = $pathinfo ;
    
    return sfView::SUCCESS;
  }
}
