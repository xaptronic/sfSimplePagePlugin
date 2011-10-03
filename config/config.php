<?php

if (sfConfig::get('app_sf_simple_page_plugin_routes_register', true) && in_array('sfSimplePage', sfConfig::get('sf_enabled_modules', array())))
{
  $this->dispatcher->connect('routing.load_configuration', array('sfSimplePageHelper', 'listenToRoutingLoadConfigurationEvent'));
}
