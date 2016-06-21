<?php
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;

// ...
$definition1 = new Definition('AppCoreBundle\Infraestructure\Impl\ContactRepository');
$definition1->setAutowiringTypes(array('AppCoreBundle\Domain\Contract\IContactRepository'));
$container->setDefinition('domain.contactrepository', $definition1);

$definition2 = new Definition('AppCoreBundle\Application\Impl\ContactService');
$definition2->setAutowired(true);
$container->setDefinition('application.contactservice', $definition2);
