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
  public function executeIndex()
  {
    // set template_path from path_info
    $pathinfo = $this->getRequest()->getPathInfo() ;
    $route_prefix = sfConfig::get("app_sf_simple_page_plugin_route_prefix","static") ;

    //remove  trailing slashes
    $route_prefix = '/'. trim( $route_prefix, '/' ) ;
    $pathinfo = preg_replace( "#^{$route_prefix}#", "", $pathinfo ) ;

    //check i18n support
    $culture = '' ;
    $cult_template_path = '' ;
    $gen_template_path = sfConfig::get("app_sf_simple_page_plugin_template_path", "static") . DIRECTORY_SEPARATOR . ltrim($pathinfo,'/');     
    if ( sfConfig::get('app_sf_simple_page_plugin_use_i18n', false ) ) {
        $culture = $this->getUser()->getCulture() ;
        $cult_template_path = sfConfig::get("app_sf_simple_page_plugin_template_path", "static") . DIRECTORY_SEPARATOR . 
            $culture . DIRECTORY_SEPARATOR . ltrim($pathinfo,'/');
    }
    
    $template_path =  ( (boolean)$culture ? $cult_template_path  : $gen_template_path ) ;
    // check whether file is ended with directory separator or not
    // if ended with '/', add "index.html"
    if (preg_match("#/$#Di", $template_path)) {
      $template_path .= "index.html";
    }
       
    // check template file
    $in = dirname($template_path);
    $name = basename($template_path);
    $files = sfFinder::type('file')
             ->maxdepth(0)
             ->name($name)
             ->ignore_version_control()
             ->in($in);
    
    // if i18n files were not found give it another try in the template path
    if ( (boolean)$culture ) {
        if ( !count($files) ) {
            $in = dirname($gen_template_path);
            $name = basename($gen_template_path);
            $files = sfFinder::type('file')
                     ->maxdepth(0)
                     ->name($name)
                     ->ignore_version_control()
                     ->in($in);
        }
    }
    $this->forward404unless(count($files)==1, "File not found ". $name );
    // set template file path
    $this->include_file_path = $files[0];
    return sfView::SUCCESS;
  }
}
