<?php
namespace jkardynia\Annotations\Permissions\Acl\Parser;

use jkardynia\Annotations\Permissions\Acl\Acl;
/**
 * AclResourceMock
 *
 * @author Jarosław Kardynia
 */
class AclResourceMock {

    /**
     * @Acl("Allow", roles="admin") 
     */
    public function doSomeAdminStuff(){
        
    }
    
    /**
     * @Acl("Allow", roles="guest") 
     */
    public function doSomeGuestStuff(){
        
    }
}
