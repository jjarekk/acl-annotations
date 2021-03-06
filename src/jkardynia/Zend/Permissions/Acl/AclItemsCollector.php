<?php
namespace jkardynia\Zend\Permissions\Acl;

use \jkardynia\Annotations\Permissions\Acl\Parser\AclParser;
use \Doctrine\Common\Annotations\AnnotationReader;
use \Zend\Permissions\Acl\Resource\GenericResource;

/**
 * AclItemsCollector
 *
 * @author Jarosław Kardynia
 * 
 */
class AclItemsCollector {
    
    /**
     * @var \Zend\Permissions\Acl\Acl 
     */
    private $zendAcl = null;
    
    /**
     * @param AclParser $aclParser 
     */
    private $aclParser = null;
    
    /**
     * This is a list of additional annotations that should be ignored by
     * default annotation reader (like @param, @author and so on).
     */
    public $ignoredAnnotations = array('events');
    
    /**
     * @param \Zend\Permissions\Acl\Acl $acl
     * @param AclParser $aclParser 
     */
    public function __construct(\Zend\Permissions\Acl\Acl $acl = null, AclParser $aclParser = null){
        
        if(null === $acl){
            $this->zendAcl = new \Zend\Permissions\Acl\Acl();
        }else{
            $this->zendAcl = $acl;
        }
        
        if(null === $aclParser){
            $this->addIgnoredAnnotationsToDefaultReader();
            $this->aclParser = new AclParser(new AnnotationReader());
        }else{
            $this->aclParser = $aclParser;
        }
    }
    
    private function addIgnoredAnnotationsToDefaultReader(){
        foreach($this->ignoredAnnotations as $annotName){
            AnnotationReader::addGlobalIgnoredName($annotName);
        }
    }
    
    /**
     * Adds new ACL entries from annotated class.
     * 
     * @param string $classesName 
     */
    public function addEntriesFromResourceClass($classesName){
        
        $currentAclResources = $this->aclParser->extractAcl(new $classesName());

        foreach($currentAclResources as $resource){
            $this->zendAcl->addResource(new GenericResource($resource->getName()));
            $this->zendAcl->setRule($resource->getOperator(), $resource->getType(), $resource->getRoles(), $resource->getName());
        }
    }
    
    /**
     * @return \Zend\Permissions\Acl\Acl 
     */
    public function getAcl(){
        return $this->zendAcl;
    }
}
