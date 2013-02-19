<?php

namespace phpx\di;

use Ray\Di\AbstractModule,
    Ray\Di\Scope,
    Ray\Sample\Transaction;

class InjectorModule extends AbstractModule {
    
    /**
     * (non-PHPdoc)
     * @see Ray\Di.AbstractModule::configure()
     */
    protected function configure() {
        $this->bindInterceptor($this->matcher->any(), $this->matcher->any(), array(new Timer));
        $this->bindInterceptor($this->matcher->any(), $this->matcher->annotatedWith('Ray\Sample\Annotation\Transactional'), array(new Transaction));
    }
    
}