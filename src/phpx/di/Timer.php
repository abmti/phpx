<?php
namespace phpx\di;

use Ray\Aop\MethodInterceptor,
Ray\Aop\MethodInvocation;

/**
 * Timer interceptor
 */
class Timer implements MethodInterceptor
{
    public function invoke(MethodInvocation $invocation)
    {
        //echo "Timer start\n";
        $mtime = microtime(true);
        $result = $invocation->proceed();
        $time = microtime(true) - $mtime;
        //echo "Timer stop:[" . sprintf('%01.7f', $time) . "] sec\n\n";
        return $result;
    }
}