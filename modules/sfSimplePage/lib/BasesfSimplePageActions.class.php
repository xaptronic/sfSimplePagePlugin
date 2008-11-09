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
    $base = sfConfig::get("mod_sfsimplepage_template_path");
    $pathinfo = ($this->getRequest()->getPathinfo() == "/")? $base . "/" : $this->getRequest()->getPathinfo();
    if (!preg_match("#^{$base}#", $pathinfo)) {
      $pathinfo = $base . $pathinfo;
    }
    $template_path = sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR . ltrim($pathinfo,'/');
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
    $this->forward404unless(count($files)==1);
    // set template file path
    $this->include_file_path = $files[0];
    return sfView::SUCCESS;
  }
}
