<?php

class KerberosLdapSchema extends AppModel {

  // LDAP schema KrbPrincipal
  public $attributes = array(
    'krbPrincipalAux' => array(
      'objectclass' => array(
        'required' => true
      ),
      'attributes' => array(
        'krbPrincipalName' => array(
          'required' => true,
          'multiple' => false,
          'extendedtype' => 'identifier_types',
          'defaulttype' => 'krbPrincipalName'
        )
      )
    )
  );

  // Required by COmanage Plugins
  public $cmPluginType = "ldapschema";
  
  // Document foreign keys
  public $cmPluginHasMany = array();

  public function assemblePluginAttributes($configuredAttributes, $provisioningData) {
    $attrs = array();

    foreach($configuredAttributes as $attr => $cfg) {
      switch($attr) {
        case 'krbPrincipalName':
          $attrs[$attr] = array();
          foreach($provisioningData['Identifier'] as $m) {
            if(isset($m['type'])
               && $m['type'] == $cfg['type']
               && $m['status'] == StatusEnum::Active) {
              $attrs[$attr] = $m['identifier'];
              break;
            }
          }
          break;
        // else we don't know what this attribute is
      }
    }
     
    return $attrs;
  }

  public function cmPluginMenus() {
    return array();
  }
}
