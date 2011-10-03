<?php
class sfSimplePageHelper
{
  /**
   * Listens to the routing.load_configuration event.
   *
   * @param sfEvent An sfEvent instance
   */
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $r = $event->getSubject();

    // preprend our routes
    // for matching
    $r->prependRoute('sfSimplePagePath', new sfRoute('/'. sfConfig::get('app_sf_simple_page_plugin_route_prefix', 'static') .'/*', array('module' => 'sfSimplePage', 'action' => 'index')));
    // for generation 
    $r->prependRoute('sfSimplePageFile', new sfRoute('/'. sfConfig::get('app_sf_simple_page_plugin_route_prefix', 'static') .'/:file', array('module' => 'sfSimplePage', 'action' => 'index')));
  }
}