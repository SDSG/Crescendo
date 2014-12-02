<?php
namespace Crescendo;

interface EnvironmentContainer
{
    public function __construct(\Application $application, array $environments);
    
    public function getEnvironments();
    
    public function getEnvironmentNames();
    
    public function getEnvironmentByName($name);
    
    public function getEnvironmentByClass($class);
    
    public function appendEnvironment(Environment $environment);
    
    public function prependEnvironment(Environment $environment);
    
    public function insertEnvironment(Environment $environment, $position);
    
    public function removeEnvironment(Environment $environment);
    
    public function removeEnvironmentByName($name);
    
    public function removeEnvironmentByClass($class);
    
    public function hasEnvironment(Environment $environment);
    
    public function hasEnvironmentWithName($name);
    
    public function hasEnvironmentWithClass($class);
}